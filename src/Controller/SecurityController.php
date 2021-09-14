<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationUserType;
use App\Form\RegistrationProType;
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
     * @Route("/registration", name="app_registration_user")
     */
    public function registrationUser(Request $request, EntityManagerInterface $manager, CategoryRepository $categoryRepository, 
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

            return $this->redirectToRoute('app_home'); // faudrait retourner sur une page de bienvenue
        }

        return $this->render('security/registration_user.html.twig', [ // page d'enregistrement des utilisateurs privés
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/registration-pro", name="app_registration_pro")
     */
    public function registrationPro(Request $request, EntityManagerInterface $manager, CategoryRepository $categoryRepository, 
                                SubCategoryRepository $subcategoryRepository, UserPasswordHasherInterface $hasher): Response
    {
        $categories = $categoryRepository->findBy([], [], 9, null);
        $subcategory = $subcategoryRepository->findAll('category');
        $user = new User();
        $form = $this->createForm(RegistrationProType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_home'); 
        }

        return $this->render('security/registration_pro.html.twig', [ // page d'enregistrement des utilisateurs professionnels
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/login", name="app_login")
     */
    public function login() {
        return $this->render('security/login.html.twig');
    }

     /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
