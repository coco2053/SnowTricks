<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\TrickGroup;
use App\Entity\TrickImage;
use App\Entity\Comment;
use App\Entity\Video;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    /**
     * [load]
     * @param  ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Create Fake Factory parametered to french
        $faker = \Faker\Factory::create('fr_FR');

        // Create Users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email())
                ->setPassword($this->encoder->encodePassword($user, '00000000'))
                ->setUsername($faker->userName())
                ->setIsActive(true)
                ->setRegisteredAt($faker->dateTimeBetween('-6 months'))
                ->setRoles(['ROLE_USER']);

            $manager->persist($user);

            $users[] = $user;
        }

        //Create 3 fake Trick Groups
        for ($i = 0; $i < 3; $i++) {
            $group = new TrickGroup();
            $group->setTitle($faker->sentence($nbWords = 1, $variableNbWords = true));

            $manager->persist($group);
            $groups[] = $group;
        }

        //Create 20 tricks
        for ($i = 0; $i < 20; $i++) {
            $trick = new Trick();
            $video = new Video();
            $video->setUrl('<iframe width="560" height="315" src="https://www.youtube.com/embed/V9xuy-rVj9w" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
            $images = [];

            for ($j = 0; $j < 4; $j++) {
                $image = new TrickImage();
                $image->setUrl('31725652cbd4c34b4772d7391b4a6814Mute1.jpg');
                $manager->persist($image);
                $images[] = $image;
            }

            $comments = [];

            for ($k = 0; $k < mt_rand(0, 10); $k++) {
                $comment = new Comment();
                $comment->setContent('<p>' . join($faker->paragraphs(mt_rand(1, 6)), '</p><p>') . '</p>')
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                        ->setUser($faker->randomElement($users));
                $manager->persist($comment);
                $comments[] = $comment;
            }

            $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

            $date = $faker->dateTimeBetween('-6 months');

            $trick->setName($faker->sentence($nbWords = 1, $variableNbWords = true))
                    ->setContent($content)
                    ->setCreatedAt($date)
                    ->setUpdatedAt($date)
                    ->addVideo($video)
                    ->setTrickGroup($faker->randomElement($groups));

            foreach ($comments as $comment) {
                $trick->addComment($comment);
            }

            foreach ($images as $image) {
                $trick->addTrickImage($image);
            }

            $manager->persist($trick);
        }

        $manager->flush();
    }
}
