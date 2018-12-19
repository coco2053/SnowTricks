<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TrickRepository;
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
            'trick' => $trick,
        ]);
    }
}
