<?php

namespace App\Security;

use App\Repository\EmployeeRepository;
use App\Controller\AdminSecurityController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\PasswordUpgradeBadge;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;


class LoginFormAdminAuthenticator extends AbstractAuthenticator
{
    private $employeeRepository;
    private $urlGenerator;
    
    public function __construct(EmployeeRepository $employeeRepository, UrlGeneratorInterface $urlGenerator)
    {
        $this->employeeRepository = $employeeRepository;  
        $this->urlGenerator = $urlGenerator;  
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * Returning null means authenticate() can be called lazily when accessing the token storage.
     */
    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'app_login_admin' && $request->isMethod('POST'); // cette fonction supports est appelé sur toute les pages (à chaque requête) elle vérifie que la page actuel vaut la page nommé et que la method et POST et envoie true puis passe à la fonction authenticate si elle retourne false on passera au prochain authentificateur dans security.yaml  
    }

    /**
     * Create a passport for the current request.
     *
     * The passport contains the user, credentials and any additional information
     * that has to be checked by the Symfony Security system. For example, a login
     * form authenticator will probably return a passport containing the user, the
     * presented password and the CSRF token value.
     *
     * You may throw any AuthenticationException in this method in case of error (e.g.
     * a UserNotFoundException when the user cannot be found).
     *
     * @throws AuthenticationException
     */
    public function authenticate(Request $request): PassportInterface
    {
        // find a employee based on an "email" form field
        $employee = $this->employeeRepository->findOneByEmail($request->get('_email')); // ou ->findOneBy(['email' => $request->get('email')])
        
        $request->getSession()->set(AdminSecurityController::LAST_EMAIL, $request->get('_email'));

        $email = $request->request->get('_email');
        $password = $request->request->get('_password');
        $valider = $request->request->get('valider');
                
        if(isset($valider) && empty($email) && empty($password)) {
            
            throw new CustomUserMessageAuthenticationException('Pour vous connecter, vous devez entrer votre email et votre mot de passe.');
        }
        if(isset($valider) && empty($email) && !empty($password)) {
            
            throw new CustomUserMessageAuthenticationException('Pour vous connecter vous devez entrer votre email.');
        }
        if(isset($valider) && !empty($email) && empty($password)) {
            
            throw new CustomUserMessageAuthenticationException('Pour vous connecter vous devez entrer votre mot de passe.');
        }
        if (!$employee) {
            // throw new UserNotFoundException; // exeption de base par defaut
            throw new CustomUserMessageAuthenticationException('Erreur de login ! vous n\'avez droit qu\'à 3 tentatives'); // exception personnalisé
        }


        return new Passport(
            new UserBadge($employee->getEmail()), 
            new PasswordCredentials($request->get('_password')), [
                // and CSRF protection using a "csrf_token" field
                new CsrfTokenBadge('authenticate', $request->get('_csrf_token'))
            ]
        );
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $request->getSession()->remove(AdminSecurityController::LAST_EMAIL);
        return new RedirectResponse($this->urlGenerator->generate('app_admin_product_list'));
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the login page or a 403 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $exception = $exception->getMessage();
        
        $request->getSession()->getFlashBag()->add('danger', $exception);
        return new RedirectResponse($this->urlGenerator->generate('app_login_admin'));
    }
}
