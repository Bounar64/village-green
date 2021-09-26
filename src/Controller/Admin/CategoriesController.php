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
    public function index(): Response
    {
        return $this->render('admin/categories/index.html.twig');
    }

    /**
     * @Route("/add", name="add")
     */
    public function addCategorie()
    {
        return $this->render('admin/add.html.twig');
    }


}
    
