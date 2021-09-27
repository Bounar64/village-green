<?php

namespace App\Controller\Admin;

use App\Entity\SubCategory;
use App\Form\SubCategoryType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/subcategory", name="app_admin_subcategory_")
 */
class SubCategoryController extends AbstractController
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
    public function subCategoryList(): Response
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        return $this->render('admin/subcategory/list_subcategory.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'Listsubcategory' => $this->subcategoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function addSubCategory(Request $request, EntityManagerInterface $manager)
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        $subcategory = new SubCategory;

        $form = $this->createForm(SubCategoryType::class, $subcategory);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($subcategory);
            $manager->flush(); 

            return $this->redirectToRoute('admin_subcategory_list');
        }

        return $this->render('admin/subcategory/add.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function editCategory(SubCategory $subcategory, Request $request, EntityManagerInterface $manager)
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        $form = $this->createForm(SubCategoryType::class, $subcategory);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($subcategory);
            $manager->flush(); 

            return $this->redirectToRoute('admin_subcategory_list');
        }

        return $this->render('admin/subcategory/edit.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteSubCategory(SubCategory $subcategory, EntityManagerInterface $manager): Response 
    {        
            $manager->remove($subcategory); 
            $manager->flush();
        
        return $this->redirectToRoute('admin_list_subcategory');
    }


}
    
