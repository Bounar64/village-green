<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository, AuthenticationUtils $authenticationUtils): Response
    {
        $categories =  $categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $subcategoryRepository->findAll('category');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('home/home.html.twig', [ // ['category' => $category ] si la clé correspond à la valeur on peut utiliser compact
            'categories' => $categories,
             'subcategory' => $subcategory,
            'error' => $error,
            'last_username' => $lastUsername
        ]); 
    }
}

