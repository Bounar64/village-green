<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationUserType;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_security_registration")
     */
    public function registration(CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository): Response
    {
        $categories = $categoryRepository->findBy([], [], 9, null);
        $subcategory = $subcategoryRepository->findAll('category');
        
        $user = new User();
        $form = $this->createForm(RegistrationUserType::class, $user);

        return $this->render('security/registration_user.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }
}
