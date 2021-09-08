<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsController extends AbstractController
{
    /**
     * @Route("/products", name="app_products")
     */
    public function subCategoryShow(CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository, ProductRepository $productRepository): Response
    {
        $categories = $categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $subcategoryRepository->findAll('category');
        $products = $productRepository->findAll();

        return $this->render('products/subcategory.html.twig', compact('categories', 'subcategory', 'products'));
    }

    /**
     * @Route("/products/{label}", name="app_products_show") // on passe le label de la sous-catégories dans l'url pour y accéder 
     */
    public function productsShow(string $label, Request $request, CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository, ProductRepository $productRepository): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $data->url_label = $label;

        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $products = $productRepository->findSearch($data);
        $count = intval($productRepository->CountResult());

        $categories = $categoryRepository->findBy([], [], 9, null);
        $subcategory = $subcategoryRepository->findAll('category');
        

        return $this->render('products/products_show.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'products' => $products,
            'count' => $count,
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/products/{label}/{label_products}-{ref}", name="app_products_details", requirements={"label_products"=".+"}) 
     */
    public function productsDetails(CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository, ProductRepository $productRepository): Response 
    {
        $categories = $categoryRepository->findBy([], [], 9, null);
        $subcategory = $subcategoryRepository->findAll('category');
        $products = $productRepository->findAll();

        return $this->render('products/products_details.html.twig',  compact('categories', 'subcategory', 'products'));
    }
       
}
