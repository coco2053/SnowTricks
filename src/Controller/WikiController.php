<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
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
    public function addEdit(Trick $trick = null, Request $request, ObjectManager $manager)
    {
        if (!$trick) {
            $trick = new Trick();
        }

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$trick->getId()) {
                $trick->setCreatedAt(new \DateTime())
                      ->setUpdatedAt(new \DateTime());
            }

            // On recupere une liste de fichiers
            $files = $request->files->get('trick') ['trickImages'];

            // On boucle dans les images
            foreach ($files as $file) {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                // On transfere le fichier vers le repertoire d'upload
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );

                $trickImage = new TrickImage;
                $trickImage->setUrl($fileName)
                           ->setTrick($trick);
                $manager->persist($trickImage);


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
