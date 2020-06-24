<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Video;

class VideoFixtures extends Fixture
{
  /**
   * [load description]
   * @param  ObjectManager $manager
   */
    public function load(ObjectManager $manager)
    {
      /*
        // Create the videos
        $video = new Video();
        $video->setUrl('<iframe width="560" height="315" src="https://www.youtube.com/embed/V9xuy-rVj9w" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
              ->setTrick($this->getReference('Trick1'));
        $manager->persist($video);

        $video = new Video();
        $video->setUrl('<iframe width="560" height="315" src="https://www.youtube.com/embed/FYQesbQXCac" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
              ->setTrick($this->getReference('Trick2'));
        $manager->persist($video);

        $video = new Video();
        $video->setUrl('<iframe width="560" height="315" src="https://www.youtube.com/embed/8CtWgw9xYRE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
              ->setTrick($this->getReference('Trick3'));
        $manager->persist($video);

        $video = new Video();
        $video->setUrl('<iframe width="560" height="315" src="https://www.youtube.com/embed/tHHxTHZwFUw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
              ->setTrick($this->getReference('Trick4'));
        $manager->persist($video);

        $video = new Video();
        $video->setUrl('<iframe width="560" height="315" src="https://www.youtube.com/embed/xGG56MWgbOA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
              ->setTrick($this->getReference('Trick5'));
        $manager->persist($video);

        $video = new Video();
        $video->setUrl('<iframe width="560" height="315" src="https://www.youtube.com/embed/PePNEXh_1N4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
              ->setTrick($this->getReference('Trick6'));
        $manager->persist($video);

        $video = new Video();
        $video->setUrl('<iframe width="560" height="315" src="https://www.youtube.com/embed/K-RKP3BizWM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
              ->setTrick($this->getReference('Trick7'));
        $manager->persist($video);

        $video = new Video();
        $video->setUrl('<iframe width="560" height="315" src="https://www.youtube.com/embed/kib-8HbKyPU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
              ->setTrick($this->getReference('Trick8'));
        $manager->persist($video);

        $video = new Video();
        $video->setUrl('<iframe width="560" height="315" src="https://www.youtube.com/embed/2RjS4-T7IdU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
              ->setTrick($this->getReference('Trick9'));
        $manager->persist($video);

        $video = new Video();
        $video->setUrl('<iframe width="560" height="315" src="https://www.youtube.com/embed/arzLq-47QFA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
              ->setTrick($this->getReference('Trick10'));
        $manager->persist($video);

        $video = new Video();
        $video->setUrl('<iframe width="560" height="315" src="https://www.youtube.com/embed/H_tSuAipjWc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
              ->setTrick($this->getReference('Trick11'));
        $manager->persist($video);

        $video = new Video();
        $video->setUrl('<iframe width="560" height="315" src="https://www.youtube.com/embed/Dafmcn0UR5g" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
              ->setTrick($this->getReference('Trick12'));
        $manager->persist($video);

        $manager->flush();
        */
    }
}
