<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
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
        $categories =  $categoryRepository->findBy(array(), array(), 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $subcategoryRepository->findAll('category');

        return $this->render('home/home.html.twig', compact('categories', 'subcategory')); // ['category' => $category ] si la clé correspond à la valeur on peut utiliser compact
    }

    /**
     * @Route("/products", name="app_products")
     */
    public function showProducts(CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository, ProductRepository $productRepository): Response
    {
        $categories = $categoryRepository->findBy(array(), array(), 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $subcategoryRepository->findAll('category');
        $products = $productRepository->findAll();
        return $this->render('products/products.html.twig', compact('categories', 'subcategory', 'products'));
    }
}
