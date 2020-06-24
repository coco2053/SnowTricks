<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/figures/{offset}", name="tricks_ajax", requirements={"offset"="\d+"})
     */
    public function ajax(TrickRepository $repo, $offset) :Response
    {
        $encoders = [new JsonEncoder()];
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $tricks = $repo->findAllBy(4, $offset);

        $tricksSer = $serializer->serialize($tricks, 'json', ['ignored_attributes' => ['content', 'createdAt', 'updatedAt', 'videos', 'comments', 'trickGroup']]);


        $response = new Response();
        $response->setContent($tricksSer);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/ajax", name="index_ajax")
     */
    public function ajaxIndex()
    {
        return $this->render('wiki/ajaxIndex.html.twig');
    }

    /**
     * @Route("/{limit}", name="show_tricks")
     *
     * [Shows all tricks]
     * @param  TrickRepository $repo
     * @param  integer         $limit
     * @return [render view]
     */
    public function showTricks(TrickRepository $repo, $limit = 8)
    {
        $tricks = $repo->findAllBy($limit, 0);

        return $this->render('wiki/index.html.twig', [
            'tricks' => $tricks
        ]);
    }
    /**
     * @Route("/image/{id}", name="show_image")
     *
     * [Shows all tricks]
     * @param  TrickRepository $repo
     * @param  integer         $limit
     * @return [render view]
     */
    public function showImage(TrickRepository $repo, $id)
    {
        $tricks = $repo->findAllByImage($id);

        return $this->render('wiki/index.html.twig');
    }

    /**
     * @Route("/figure/{id}", name="show")
     *
     * [Show a specific trick]
     * @param  Trick                  $trick
     * @param  Request                $request
     * @param  EntityManagerInterface $manager
     * @param  PaginatorInterface     $paginator
     * @return [render view]
     */
    public function show(Trick $trick, Request $request, EntityManagerInterface $manager, PaginatorInterface $paginator)
    {
        $comment = new Comment;
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

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
     *
     * [Allows to write a new trick]
     * @param Request                $request
     * @param EntityManagerInterface $manager
     * @return [render view]
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
     *
     * [Allows to modify an existing trick]
     * @param  Trick                  $trick
     * @param  Request                $request
     * @param  EntityManagerInterface $manager
     * @return [render view]
     */
    public function edit(Trick $trick, Request $request, EntityManagerInterface $manager)
    {

        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecté pour acceder à cette page !');

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setUpdatedAt(new \DateTime());
            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'notice',
                'L\'article a bien été modifié !'
            );

             return $this->redirectToRoute('show', ['id' => $trick->getId()]);
        }

        return $this->render('wiki/edit.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick
        ]);
    }

    /**
     * @Route("/wiki/{id}/supprimer", name="delete_trick")
     *
     * [Allows to delete an existing trick]
     * @param  Trick                  $trick
     * @param  EntityManagerInterface $manager
     * @return [redirection]
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
