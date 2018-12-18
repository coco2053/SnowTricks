<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Entity\TrickGroup;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create Fake Factory parametered to french
        $faker = \Faker\Factory::create('fr_FR');

        //Create 4 fake Trick Groups
        for($i = 1; $i <= 3; $i++) {

            $group = new TrickGroup();
            $group->setTitle($faker->sentence());

            $manager->persist($group);

            //Create between 4 and 6 tricks
            for($j = 1; $j <= mt_rand(4, 6); $j++) {
                $trick = new Trick();

                $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                $date = $faker->dateTimeBetween('-6 months');

                $trick->setName($faker->sentence())
                        ->setContent($content)
                        ->setCreatedAt($date)
                        ->setUpdatedAt($date)
                        ->setTrickGroup($group);

                $manager->persist($trick);
            }
        }

        $manager->flush();
    }
}
