<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="app_profil_user")
     */
    public function profil(): Response
    {
        return $this->render('user/base_profil.html.twig');
    }
}
