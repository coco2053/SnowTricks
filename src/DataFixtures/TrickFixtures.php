<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Entity\TrickGroup;
use App\Entity\TrickImage;

class TrickFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // Create Fake Factory parametered to french
        $faker = \Faker\Factory::create('fr_FR');

        $h = 0;

        //Create 3 fake Trick Groups
        for ($i = 1; $i <= 3; $i++) {
            $group = new TrickGroup();
            $group->setTitle($faker->sentence());

            $manager->persist($group);


            //Create 4 tricks
            for ($j = 1; $j <= 4; $j++) {
                $h++;
                $trick = new Trick();

                $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                $date = $faker->dateTimeBetween('-6 months');

                $trick->setName($faker->sentence())
                        ->setContent($content)
                        ->setCreatedAt($date)
                        ->setUpdatedAt($date)
                        ->setTrickGroup($group);

                $manager->persist($trick);

                // Create 4 TrickImage
                for ($k = 1; $k <= 4; $k++) {
                    $image = new TrickImage();
                    $image->setUrl($faker->imageUrl());
                    $image->setTrick($trick);
                    $manager->persist($image);
                }
                // Reference for VideoFixtures
                $this->setReference('Trick' .$h, $trick);
            }
        }

        $manager->flush();
    }
}
