<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\EmailVerifier;
use App\Form\RegistrationProType;
use App\Form\RegistrationUserType;
use Symfony\Component\Mime\Address;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

   /**
     * @Route("/register", name="app_register_user")
     */
    public function registerUser(Request $request, EntityManagerInterface $manager, CategoryRepository $categoryRepository, 
                                SubCategoryRepository $subcategoryRepository, UserPasswordHasherInterface $hasher, AuthenticationUtils $authenticationUtils): Response
    {
        $categories = $categoryRepository->findBy([], [], 9, null);
        $subcategory = $subcategoryRepository->findAll('category');
        $user = new User();
        $form = $this->createForm(RegistrationUserType::class, $user);
        $form->handleRequest($request);

          // get the login error if there is one
          $error = $authenticationUtils->getLastAuthenticationError();

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
        
            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('noreply@village-green.com', 'Village-Green'))
                    ->to($user->getEmail())
                    ->subject('Veuillez confirmez votre e-mail')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email
        }

        return $this->render('registration/register_user.html.twig', [ // page d'enregistrement des utilisateurs privés
            'error' => $error,
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/register-pro", name="app_register_pro")
     */
    public function registerPro(Request $request, EntityManagerInterface $manager, CategoryRepository $categoryRepository, 
                                SubCategoryRepository $subcategoryRepository, UserPasswordHasherInterface $hasher, AuthenticationUtils $authenticationUtils): Response
    {
        $categories = $categoryRepository->findBy([], [], 9, null);
        $subcategory = $subcategoryRepository->findAll('category');
        $user = new User();
        $form = $this->createForm(RegistrationProType::class, $user);
        $form->handleRequest($request);

         // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
        
            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('noreply@village-green.fr', 'Village-Green'))
                    ->to($user->getEmail())
                    ->subject('Veuillez confirmez votre e-mail')
                    ->htmlTemplate('emails/registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email
        }

        return $this->render('registration/register_pro.html.twig', [ // page d'enregistrement des utilisateurs professionnels
            'error' => $error,
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_home');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre e-mail a bien était vérifié.');

        return $this->redirectToRoute('app_home');
    }
}
