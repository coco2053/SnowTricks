<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Entity\TrickGroup;
use App\Entity\TrickImage;

class TrickFixtures extends Fixture
{
    /**
     * [load]
     * @param  ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Create Fake Factory parametered to french
        $faker = \Faker\Factory::create('fr_FR');

        $h = 0;

        //Create 3 fake Trick Groups
        for ($i = 1; $i <= 3; $i++) {
            $group = new TrickGroup();
            $group->setTitle($faker->sentence($nbWords = 1, $variableNbWords = true));

            $manager->persist($group);


            //Create 4 tricks
            for ($j = 1; $j <= 4; $j++) {
                $h++;
                $trick = new Trick();

                $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                $date = $faker->dateTimeBetween('-6 months');

                $trick->setName($faker->sentence($nbWords = 1, $variableNbWords = true))
                        ->setContent($content)
                        ->setCreatedAt($date)
                        ->setUpdatedAt($date)
                        ->setTrickGroup($group);

                $manager->persist($trick);

                // Reference for VideoFixtures
                $this->setReference('Trick' .$h, $trick);
            }
        }
        $manager->flush();
    }
}
