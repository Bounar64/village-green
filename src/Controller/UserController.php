<?php

namespace App\Controller;

use App\Form\EditProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/profil")
 */
class UserController extends AbstractController
{
    /**
     * @Route("", name="app_profil_user")
     */
    public function profil(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser(); // $this->getUser() récupère l'utilisateur actuellement connecté
        $form = $this->createForm(EditProfilType::class, $user); 
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Profil mis à jour !');
            return $this->redirectToRoute('app_profil_user');  
        }
        elseif($form->isSubmitted() && !$form->isValid()) {

            $this->addFlash('danger', 'Une erreur est survenue lors de l\'envoi du formulaire.');
            return $this->redirectToRoute('app_profil_user'); 
        }

        return $this->render('user/base_profil.html.twig', [
            'form' => $form->createView()
        ]
        
        );
    }

    /**
     * @Route("/edit", name="app_profil_user_edit")
     */
    public function editProfil(): Response
    {
        // Si l'on est connecté on ne peux pas accédé à la page login
        if ($this->getUser()) {
            
            return $this->redirectToRoute('app_profil_user');
        }
        else {
            return $this->redirectToRoute('app_home'); // Pour évité d'accéder au script d'édition même sans login
        }

        return $this->render('user/page/edit_profil.html.twig');
    }

}
