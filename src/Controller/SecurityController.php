<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\AvatarImage;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
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
             $user->setConfirmationToken(bin2hex(random_bytes(32)));

            $manager->persist($user);

            $manager->flush();

            $title = 'Validation de votre compte sur Snowtricks';
            $view = 'mail/registration.html.twig';
            $mailer->sendMail($user, $title, $view);

            $this->addFlash(
                'notice',
                'Un email vous a été envoyé à l\'adresse ' .$user->getEmail() . ' contenant un lien pour valider votre inscription. Pensez à vérifier votre courrier indésirable si vous ne le trouvez pas.'
            );

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
     * @Route("/validation/{token}", name="security_confirm")
     */
    public function validate(string $token, UserRepository $userRepository, ObjectManager $manager)
    {
        if (!\is_null($user = $userRepository->checkRegistrationToken($token))) {
            $user->setIsActive(true);

            $manager->persist($user);

            $manager->flush();

            //$userRepository->save($user);

            $this->addFlash(
                'notice',
                'Votre compte est maintenant validé ! Vous pouvez désormais vous connecter.'
            );

            return $this->render('security/login.html.twig');
        }

        return $this->render('error/register_validation_error.html.twig');
    }
}
