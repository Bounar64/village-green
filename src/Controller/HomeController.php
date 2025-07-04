<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository): Response
    {
        $categories =  $categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $subcategoryRepository->findAll('category');

        return $this->render('home/home.html.twig', [ // ['category' => $category ] si la clé correspond à la valeur on peut utiliser compact
            'categories' => $categories,
             'subcategory' => $subcategory
        ]); 
    }
}

