<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\AvatarImage;
use App\Form\RegistrationType;
use App\Service\Mailer;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, Mailer $mailer)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);

            $manager->flush();

            $user->setConfirmationToken(bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)));
            $title = 'Validation de votre compte sur Snowtricks';
            $view = 'mail/registration.html.twig';
            $mailer->sendMail($user, $title, $view);

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login()
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/validation/{token}", methods={"GET"}, name="security_confirm")
     */
    public function validate(string $token)
    {
        return $this->render('security/login.html.twig');
    }
}
