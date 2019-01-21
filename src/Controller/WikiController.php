<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TrickRepository;
use App\Form\TrickType;
use App\Form\CommentType;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Entity\TrickImage;

class WikiController extends AbstractController
{
    /**
     * @Route("/{limit}", name="show_tricks", requirements={"limit"="\d+"})
     */
    public function showTricks(TrickRepository $repo, $limit = 8)
    {
        $tricks = $repo->findAllBy($limit);
        $limit += 4;

        if ($limit > 8) {
            return $this->render('wiki/index.html.twig', [
                'tricks' => $tricks,
                'limit' => $limit,
                'hash' => 'hash'
            ]);
        }

        return $this->render('wiki/index.html.twig', [
            'tricks' => $tricks,
            'limit' => $limit
        ]);
    }

    /**
     * @Route("/figure/{id}", name="show")
     */
    public function show(Trick $trick, Request $request, EntityManagerInterface $manager, PaginatorInterface $paginator)
    {
        $comment = new Comment;
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        //$paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $trick->getComments(),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime())
                    ->setTrick($trick)
                    ->setUser($this->getUser());
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('show', ['id' => $trick->getId()]);
        }

        return $this->render('wiki/show.html.twig', [
            'trick' => $trick,
            'comments' => $result,
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/wiki/ajouter", name="add_trick")
     */
    public function add(Request $request, EntityManagerInterface $manager)
    {

        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté pour acceder à cette page !');

        $form = $this->createForm(TrickType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             $trick = $form->getData();

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Votre article a bien été ajouté !'
            );

            return $this->redirectToRoute('show', ['id' => $trick->getId()]);
        }

        return $this->render('wiki/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("wiki/{id}/modifier", name="edit_trick")
     */
    public function edit(Trick $trick, Request $request, EntityManagerInterface $manager)
    {

        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté pour acceder à cette page !');

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash(
                'notice',
                'L\'article a bien été modifié !'
            );

             return $this->redirectToRoute('show', ['id' => $trick->getId()]);
        }

        return $this->render('wiki/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/wiki/{id}/supprimer", name="delete_trick")
     */
    public function delete(Trick $trick, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté pour acceder à cette page !');

        $manager->remove($trick);

        $manager->flush();

            $this->addFlash(
                'notice',
                'Article supprimé !'
            );

        return $this->redirectToRoute('show_tricks');
    }
}
