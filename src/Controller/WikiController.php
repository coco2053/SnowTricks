<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/add", name="add_trick")
     */
    public function addEdit(Request $request, EntityManagerInterface $manager)
    {

        $form = $this->createForm(TrickType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             $trick = $form->getData();

            if (!$trick->getId()) {
                $trick->setCreatedAt(new \DateTime())
                      ->setUpdatedAt(new \DateTime());
            }
            $trickImages = $trick->getTrickImages();

            // On recupere une liste de fichiers
            //$files = $request->files->get('trick') ['trickImages'];

            // On boucle dans les images
            foreach ($trickImages as $trickImage) {
                $file = $trickImage->getFile();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                // On transfere le fichier vers le repertoire d'upload
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );

                $trickImage->setUrl($fileName);

                //$manager->persist($trickImage);
                $trick->addTrickImage($trickImage);
            }

            $manager->persist($trick);
            $manager->flush();

            return $this->redirectToRoute('show', ['id' => $trick->getId()]);
        }

        return $this->render('wiki/add.html.twig', [
            'formTrick' => $form->createView()
        ]);
    }
}
