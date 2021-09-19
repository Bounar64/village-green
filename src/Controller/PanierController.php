<?php

namespace App\Controller;

use App\Repository\ProductRepository;
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
    public function index(SessionInterface $session): Response
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');
        $products = $this->productRepository->findAll();  

        $panier = $session->get('panier', []);
        $panierData = []; // Crée une variable ou l'on stockera toutes les données du panier

        foreach($panier as $id => $quantity) { // On boucle dans le panier 
            $panierData[] = [  // On ajoute dans ce $panierData les produits en question via l'id et la quantité
                'product' =>  $this->productRepository->find($id), // On récupère toute le infos du produits via son id
                'quantity' => $quantity // la quantité vaut le nombre de fois l'id sélectionné
            ];
        }

        $total = 0; // initialise le total à 0
       // boucle pour avoir le total du panier avec réduction et sans s'il y en a pas
        foreach($panierData as $item) {
            $discountPrice = $item['product']->getPrice() - ($item['product']->getDiscount() / 100 * $item['product']->getPrice()); // Prix avec réduction

            if($item['product']->getDiscount() == NULL) { 
                $totalItem = $item['product']->getPrice() * $item['quantity']; // total pour les prix avec réduction
                $total += $totalItem; 
            } else {
                $totalItem = $discountPrice * $item['quantity'];  // total pour les prix sans réduction
                $total += $totalItem;
            }  
        }

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
    public function add($id, SessionInterface $session) // On récupère les services de la session via sessioninterface
    {
        $panier = $session->get('panier', []); // Je vérifie s'il y a une donnée 'panier' dans ma session et par défaut si c'est vide c'est un tableau vide dans la variable $panier
        
        if(!empty($panier[$id])) { // Si le produit existe déjà dans le panier on rajoute en plus 
            $panier[$id]++;
        } else {
            $panier[$id] = 1; // Sinon on ajoute le produit 1 fois
        }

        $session->set('panier', $panier); // On sauvegarde l'état de notre panier actuel 
    }

}
