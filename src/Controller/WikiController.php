<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WikiController extends AbstractController
{
    /**
     * @Route("/", name="show_tricks")
     */
    public function showTricks()
    {
        return $this->render('wiki/index.html.twig', [
            'controller_name' => 'WikiController',
        ]);
    }
}
