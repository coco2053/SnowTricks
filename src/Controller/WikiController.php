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
            'controller_name' => 'WikiController',
            'tricks' => $tricks
        ]);
    }
}
