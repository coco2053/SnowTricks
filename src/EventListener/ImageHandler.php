<?php
namespace App\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Entity\Trick;

class ImageHandler
{
    public function prePersist(LifecycleEventArgs $args)
    {

        $entity = $args->getObject();

        // only act on some "Trick" entity
        if (!$entity instanceof Trick) {
            return;
        }

        $entityManager = $args->getObjectManager();

        $trickImages = $entity->getTrickImages();

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
