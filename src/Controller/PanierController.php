<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\panier\PanierService;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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

        $TotalItemsCart = $panierService->TotalItemsCart();

        return $this->render('panier/panier.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'products' => $products,
            'items' => $panierData,
            'total' => $total,
            'TotalItemsCart' => $TotalItemsCart
        ]);

    }

    /**
     * Ajouter un produit au panier 
     * 
     * @Route("/add/{id}", name="app_panier_add")
     */
    public function add($id, PanierService $panierService, SessionInterface $session) 
    {
        $panierService->add($id);

        return $this->redirectToRoute("app_products_show", ['label' => $session->get('label')]); // on passe la route et le paramètre label qu'on à récupérer via la session envoyé depuis le ProductController
    }

    /**
     * Supprimer un produit du panier 
     *
     * @Route("/delete/{id}", name="app_panier_delete")
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

    /**
     * incrémenter un produit du panier 
     *
     * @Route("/increase/{id}", name="app_panier_increase")
     */
    public function increase($id, PanierService $panierService) 
    {
       $panierService->increase($id);
        
        return $this->redirectToRoute("app_panier");
    }

    /**
     * décrémenter un produit du panier 
     *
     * @Route("/remove/{id}", name="app_panier_remove")
     */
    public function remove($id, PanierService $panierService) 
    {
       $panierService->remove($id);
        
        return $this->redirectToRoute("app_panier");
    }

    /**
     * fonction qui envoie dans la session le nombre total de produit dans le panier
     */
    public function TotalItemsCart(PanierService $panierService) 
    {
        $panierService->TotalItemsCart();
        return $this->redirectToRoute("app_panier");
    }
}
