<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="app_profil_user")
     */
    public function profilUser(UserRepository $userRepository): Response
    {
        $user = $this->userRepository->findAll('user');

        return $this->render('user/profil_user.html.twig',  compact('user'));
    }
}
