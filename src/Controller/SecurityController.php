<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationUserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_security_registration")
     */
    public function registration(): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationUserType::class, $user);

        return $this->render('security/registration_user.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
