<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\AvatarImage;
use App\Form\RegistrationType;
use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
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
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/validation/{token}", name="security_confirm")
     */
    public function validate(string $token, UserRepository $userRepository, ObjectManager $manager)
    {
        if (!\is_null($user = $userRepository->checkConfirmationToken($token))) {
            $user->setIsActive(true);
            $user->setConfirmationToken(null);

            $manager->persist($user);

            $manager->flush();

            $this->addFlash(
                'notice',
                'Votre compte est maintenant validé ! Vous pouvez désormais vous connecter.'
            );

            return $this->redirectToRoute('security_login');
        }

        return $this->render('error/register_validation_error.html.twig');
    }

    /**
     * @Route("/demande-changement-de-mdp", name="security_password_claim")
     */
    public function changePasswordClaim(Request $request, UserRepository $userRepository, ObjectManager $manager, Mailer $mailer)
    {

        if (isset($_POST['mail'])) {
            $email = strip_tags($_POST['mail']);

            if (!\is_null($user = $userRepository->findOneBy(array('email' => $email)))) {
                $user->setPasswordToken(bin2hex(random_bytes(32)));

                $manager->persist($user);

                $manager->flush();

                $title = 'Demande de reinitialisation du mot de passe sur Snowtricks';
                $view = 'mail/change_password.html.twig';
                $mailer->sendMail($user, $title, $view);

                $this->addFlash(
                    'notice',
                    'Un email vous a été envoyé à l\'adresse ' .$user->getEmail() . ' contenant un lien pour reinitialiser votre mot de passe. Pensez à vérifier votre courrier indésirable si vous ne le trouvez pas.'
                );

                return $this->redirectToRoute('security_login');
            }
            return $this->render('error/change_password_claim_error.html.twig');
        }
        return $this->render('security/change_password_claim.html.twig', [
        ]);
    }


    /**
     * @Route("/reinitialiser-mdp/{token}", name="security_change_password")
     */
    public function changePassword(Request $request, string $token, UserRepository $userRepository, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        if (!\is_null($user = $userRepository->checkPasswordToken($token))) {
            $form = $this->createForm(ChangePasswordType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $hash = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);
                $user->setPasswordToken(null);

                $manager->persist($user);

                $manager->flush();

                $this->addFlash(
                    'notice',
                    'Votre mot de passe a bien été modifié !'
                );

                return $this->redirectToRoute('security_login');
            }

            return $this->render('security/change_password.html.twig', [
                'form' => $form->createView()
            ]);
        }
        return $this->render('error/change_password_error.html.twig');
    }
}
