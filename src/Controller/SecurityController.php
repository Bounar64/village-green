<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationUserType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, CategoryRepository $categoryRepository, 
                                 SubCategoryRepository $subcategoryRepository, UserPasswordHasherInterface $hasher): Response
    {
        $categories = $categoryRepository->findBy([], [], 9, null);
        $subcategory = $subcategoryRepository->findAll('category');
        $user = new User();
        $form = $this->createForm(RegistrationUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/registration_user.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login() {
        return $this->render('security/popover_login.html.twig');
    }

}
