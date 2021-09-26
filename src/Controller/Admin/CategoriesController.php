<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/categories", name="app_admin_categories_")
 */
class CategoriesController extends AbstractController
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
    public function CategoriesList(): Response
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        return $this->render('admin/categories/list_categories.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'Listcategory' => $this->categoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function addCategorie(Request $request, EntityManagerInterface $manager)
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        $category = new Category;

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($category);
            $manager->flush(); 

            return $this->redirectToRoute('admin_categories_list');
        }

        return $this->render('admin/categories/add.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function editCategorie(Category $category, Request $request, EntityManagerInterface $manager)
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($category);
            $manager->flush(); 

            return $this->redirectToRoute('admin_categories_list');
        }

        return $this->render('admin/categories/edit.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Category $category, EntityManagerInterface $manager): Response 
    {        
            $manager->remove($category); 
            $manager->flush();
        
        return $this->redirectToRoute('admin_categories_list');
    }


}
    
