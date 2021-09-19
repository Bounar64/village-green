<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\panier\PanierService;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/panier")
 */
class PanierController extends AbstractController
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
     * @Route("", name="app_panier")
     */
    public function index(PanierService $panierService): Response
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');
        $products = $this->productRepository->findAll();  

        $panierData = $panierService->getFullPanier();
        $total = $panierService->getTotal();

        return $this->render('panier/panier.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'products' => $products,
            'items' => $panierData,
            'total' => $total
        ]);
    }

    /**
     * Ajouter un produit au panier 
     * 
     * @Route("/add/{id}", name="app_panier_add")
     */
    public function add($id, PanierService $panierService) 
    {
        $panierService->add($id);

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * Supprimer un produit du panier 
     *
     * @Route("/remove/{id}", name="app_panier_delete")
     */
    public function delete($id, PanierService $panierService) 
    {
       $panierService->delete($id);
        
        return $this->redirectToRoute("app_panier");
    }

    /**
     * Vider mon panier
     *
     * @Route("/clear", name="app_panier_clear")
     */
    public function clear(PanierService $panierService)
    {    
        $panierService->clearPanier();
        return $this->redirectToRoute("app_panier");
    }
}
