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
     * @Route("/products/", name="app_sub_category")
     */
    public function showSubCategory () {
        
        return $this->render('products/subcategory.html.twig');
    }
}
