<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Address;
use App\Form\ChangePasswordFormType;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use App\Form\ResetPasswordRequestFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;

/**
 * @Route("/reset-password")
 */
class ResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    private $categoryRepository;
    private $subcategoryRepository;
    private $resetPasswordHelper;

    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper, CategoryRepository $categoryRepository, 
                                SubCategoryRepository $subcategoryRepository)
    {                          
        $this->categoryRepository = $categoryRepository;
        $this->subcategoryRepository = $subcategoryRepository;  
        $this->resetPasswordHelper = $resetPasswordHelper;
    }

    /**
     * Display & process form to request a password reset.
     *
     * @Route("", name="app_forgot_password_request")
     */
    public function request(Request $request, MailerInterface $mailer): Response
    {
        if ($this->getUser()) {

            $this->addFlash('danger', 'Vous êtes déjà connecté !');
            
            return $this->redirectToRoute('app_home');
        }

        $categories = $this->categoryRepository->findBy([], [], 9, null); 
        $subcategory = $this->subcategoryRepository->findAll('category');
        
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processSendingPasswordResetEmail(
                $form->get('email')->getData(),
                $mailer
            );
        }

        return $this->render('reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
            'categories' => $categories,
            'subcategory' => $subcategory
        ]);
    }

    /**
     * Confirmation page after a user has requested a password reset.
     *
     * @Route("/check-email", name="app_check_email")
     */
    public function checkEmail(): Response
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); 
        $subcategory = $this->subcategoryRepository->findAll('category');

        // Generate a fake token if the user does not exist or someone hit this page directly.
        // This prevents exposing whether or not a user was found with the given email address or not
        if (null === ($resetToken = $this->getTokenObjectFromSession())) {
            $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
        }

        return $this->render('reset_password/check_email.html.twig', [
            'resetToken' => $resetToken,
            'categories' => $categories,
            'subcategory' => $subcategory
        ]);
    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     *
     * @Route("/reset/{token}", name="app_reset_password")
     */
    public function reset(Request $request, UserPasswordHasherInterface $passwordHasher, string $token = null): Response
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); 
        $subcategory = $this->subcategoryRepository->findAll('category');

        if ($token) {
            // We store the token in session and remove it from the URL, to avoid the URL being
            // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
            $this->storeTokenInSession($token);  

            return $this->redirectToRoute('app_reset_password');
        }

        $token = $this->getTokenFromSession(); // On stock le token récuperer dans une variale $token
        if (null === $token) { // Si le token est null un message d'erreur est affiché
            throw $this->createNotFoundException('Aucun Token de réinitialisation de mot de passe trouvé dans l\'URL ou dans la session.');
        }

        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token); // On vérifie le token si il est valide ou pas 
        } catch (ResetPasswordExceptionInterface $e) { // s'il n'est pas valide on affiche un message d'erreur
            $this->addFlash('reset_password_error', sprintf( 
                '%s', 
                $e->getReason()
            )); // récupère tout les messages d'erreur dans l'interface et les affiches %s ou afficher un message type unique type "Un problème est survenu lors de la validation de votre demande de réinitialisation"

            return $this->redirectToRoute('app_forgot_password_request'); // Et on redirige vers la page de réinitialisation 'entrer e-mail' avec le message d'erreur
        }

        // The token is valid; allow the user to change their password.
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // A password reset token should be used only once, remove it.
            $this->resetPasswordHelper->removeResetRequest($token);

            // Encode the plain password, and set it.
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('newPassword')->getData()
            );

            $user->setPassword($hashedPassword);
            $this->getDoctrine()->getManager()->flush();

            // The session is cleaned up after the password has been changed.
            $this->cleanSessionAfterReset();

            $this->addFlash('success', 'Mot de passe modifié avec succès');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
            'categories' => $categories,
            'subcategory' => $subcategory
                ]);
    }

    private function processSendingPasswordResetEmail(string $emailFormData, MailerInterface $mailer): RedirectResponse
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $emailFormData]); // On récupère l'utilisateur via son e-mail entrer dans la bdd
        
        // Do not reveal whether a user account was found or not.
        if (!$user) {
            return $this->redirectToRoute('app_check_email');  // On vérifie si l'utilisateur existe
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user); // Si l'utilisateur existe on génére un token
        } catch (ResetPasswordExceptionInterface $e) {
            // If you want to tell the user why a reset email was not sent, uncomment
            // the lines below and change the redirect to 'app_forgot_password_request'.
            // Caution: This may reveal if a user is registered or not.
            //
            // $this->addFlash('reset_password_error', sprintf(
            //     'There was a problem handling your password reset request - %s',
            //     $e->getReason()
            // ));

            return $this->redirectToRoute('app_check_email'); // On redirige vers la page pour nous envoyer ce lien 
        }

        $email = (new TemplatedEmail()) // Le mail qu'on recevra
            ->from(new Address('noreply@village-green.com', 'Village-Green'))
            ->to($user->getEmail())
            ->subject('Réinitialisation du mot de passe')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'resetToken' => $resetToken,
            ])
        ;

        $mailer->send($email);

        // Store the token object in session for retrieval in check-email route.
        $this->setTokenObjectInSession($resetToken);

        return $this->redirectToRoute('app_check_email');
    }
}
