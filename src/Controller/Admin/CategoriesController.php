<?php

namespace App\Controller\Admin;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/categories", name="admin_categories_")
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
     * @Route("/", name="home")
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
     * @Route("/add", name="admin_categories_add")
     */
    public function addCategorie()
    {
        return $this->render('admin/add.html.twig');
    }


}
    
