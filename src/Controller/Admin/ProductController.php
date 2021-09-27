<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/product", name="app_admin_product_")
 */
class ProductController extends AbstractController
{
    private $categoryRepository;
    private $subcategoryRepository;
    private $productRepository;

    public function __construct(CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository, ProductRepository $productRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->subcategoryRepository = $subcategoryRepository;
        $this->productRepository = $productRepository;
    }
    
    /**
     * @Route("/", name="list")
     */
    public function ProductList(): Response
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        return $this->render('admin/product/list_product.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'Listproduct' => $this->productRepository->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function addProduct(Request $request, EntityManagerInterface $manager)
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        $product = new Product;

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($product);
            $manager->flush(); 

            return $this->redirectToRoute('admin_list_product');
        }

        return $this->render('admin/product/add.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function editCategories(Product $product, Request $request, EntityManagerInterface $manager)
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        $form = $this->createForm(CategoryType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($product);
            $manager->flush(); 

            return $this->redirectToRoute('admin_list_product');
        }

        return $this->render('admin/prodcut/edit.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteCategories(Product $product, EntityManagerInterface $manager): Response 
    {        
            $manager->remove($product); 
            $manager->flush();
        
        return $this->redirectToRoute('admin_list_product');
    }


}
    
