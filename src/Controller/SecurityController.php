<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Mailer;
use App\Entity\AvatarImage;
use App\Form\RegistrationType;
use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     *
     * [Handles registration process]
     * @param  Request                      $request
     * @param  EntityManagerInterface       $manager
     * @param  UserPasswordEncoderInterface $encoder
     * @param  Mailer                       $mailer
     * @return [render view]
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, Mailer $mailer)
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
     *
     * [Handles login process]
     * @param  AuthenticationUtils $authenticationUtils
     * @return [render view]
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
     *
     * [Handles logout process]
     * @return [void]
     */
    public function logout()
    {
    }

    /**
     * @Route("/validation/{token}", name="security_confirm")
     *
     * [Handles registration validation process]
     * @param  string                 $token
     * @param  UserRepository         $userRepository
     * @param  EntityManagerInterface $manager
     * @return [render view]
     */
    public function validate(string $token, UserRepository $userRepository, EntityManagerInterface $manager)
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
     *
     * [Handles user's password reset claim]
     * @param  Request                $request
     * @param  UserRepository         $userRepository
     * @param  EntityManagerInterface $manager
     * @param  Mailer                 $mailer
     * @return [render view]
     */
    public function changePasswordClaim(Request $request, UserRepository $userRepository, EntityManagerInterface $manager, Mailer $mailer)
    {

        if (null !== $request->request->get('mail')) {
            $email = strip_tags($request->request->get('mail'));

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
     *
     * [Handles user's password reset process]
     * @param  Request                      $request
     * @param  string                       $token
     * @param  UserRepository               $userRepository
     * @param  EntityManagerInterface       $manager
     * @param  UserPasswordEncoderInterface $encoder
     * @return [render view]
     */
    public function changePassword(Request $request, string $token, UserRepository $userRepository, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
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
