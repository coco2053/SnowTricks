<?php
namespace App\Service;

class ImageHandler
{
    public function handleImages()
    {
        $trickImages = $this->getTrickImages();

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
    }
}
