<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminSecurityController extends AbstractController
{
    public const LAST_EMAIL = 'login_last_email';
    /**
     * @Route("/login_admin", name="app_login_admin", methods={"GET", "POST"})
     */
    public function login(): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        return $this->render('security/login_admin.html.twig');
    }

    /**
     * @Route("/logout_admin", name="app_logout_admin", methods={"GET"})
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
