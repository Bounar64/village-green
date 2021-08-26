<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsController extends AbstractController
{
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

    /**
     * @Route("/products/{label}", name="app_sub_category_show") // on passe le label de la sous-catégories dans l'url pour y accéder 
     */
    public function showSubCategory(CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository, ProductRepository $productRepository): Response
    {
        $categories = $categoryRepository->findBy(array(), array(), 9, null);
        $subcategory = $subcategoryRepository->findAll('category');
        $products = $productRepository->findAll();

        return $this->render('products/subcategory_show.html.twig', compact('categories', 'subcategory', 'products'));
    }
}
