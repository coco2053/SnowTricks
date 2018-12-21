<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\TrickRepository;
use App\Form\TrickType;
use App\Entity\Trick;

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
     * @Route("/add", name="add_trick")
     */
    public function addEdit(Trick $trick = null, Request $request, ObjectManager $manager)
    {
        if (!$trick) {
            $trick = new Trick();
        }

        $form = $this->createForm(TrickType::class, $trick);

        return $this->render('wiki/add.html.twig', [
            'formTrick' => $form->createView()
        ]);
    }
}
