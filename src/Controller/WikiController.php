<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TrickRepository;
use App\Form\TrickType;
use App\Entity\Trick;
use App\Entity\TrickImage;

class WikiController extends AbstractController
{
    /**
     * @Route("/", name="show_tricks")
     */
    public function showTricks(TrickRepository $repo)
    {
        $tricks = $repo->findAll();

        return $this->render('wiki/index.html.twig', [
            'tricks' => $tricks
        ]);
    }

    /**
     * @Route("/wiki/{id}", name="show")
     */
    public function show(Trick $trick)
    {

        return $this->render('wiki/show.html.twig', [
            'trick' => $trick
        ]);
    }

    /**
     * @Route("/ajouter", name="add_trick")
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
     * @Route("/supprimer/{id}", name="delete_trick")
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
