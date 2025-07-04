<?php

namespace App\Service\panier;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierService extends AbstractController
{

    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository) // On récupère les services de la session via SessionInterface
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    /**
     * fonction ajouter un produit au panier 
     *
     */
    public function add(int $id) 
    {
        $panier = $this->session->get('panier', []); // Je vérifie s'il y a une donnée 'panier' dans ma session et par défaut si c'est vide c'est un tableau vide
        
        if(!empty($panier[$id])) { // Si le produit existe déjà dans le panier on rajoute on incrémente 
            $panier[$id]++;
        } else {
            $panier[$id] = 1; // Sinon on ajoute le produit 1 fois
        }
        
        $this->session->set('panier', $panier); // On sauvegarde sans la session l'état de notre panier actuel après modification
    }

    /**
     * fonction supprimer un produit du panier
     *
     */
    public function delete(int $id) 
    {
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])) { // Si le produit existe on le supprime
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    /**
     * fonction qui récupère le total des informations des produits
     *
     */
    public function getFullPanier(): array 
    {
        $panier = $this->session->get('panier', []);
        $panierData = []; // Crée une variable où l'on stockera toutes les données du panier

        foreach($panier as $id => $quantity) { // On boucle dans le panier 
            $panierData[] = [  // On ajoute dans ce $panierData les produits en question via l'id et la quantité
                'product' =>  $this->productRepository->find($id), // On récupère toute le infos du produits via son id
                'quantity' => $quantity // la quantité vaut le nombre de fois l'id sélectionné
            ];
        }

        return $panierData;
    }

    /**
     * fonction qui calcul le total (prix) du panier TTC
     *
     * @return float
     */
    public function getTotalTTC() 
    {
        $total = 0; // initialise le total à 0
        $panierData = $this->getFullPanier();

        // boucle pour avoir le total du panier avec réduction et sans réduction TTC
        foreach($panierData as $item) {

            $priceTTC = $item['product']->getPrice() + ( 20 / 100 * $item['product']->getPrice()); // prix TTC

            if($item['product']->getDiscount() == NULL) { 
                $totalItem = $priceTTC * $item['quantity']; // total pour les prix sans réduction TTC
                $total += $totalItem; 
            } else {
                if($this->getUser()) {
                    $discountType = $item['product']->getDiscount() + $this->getUser()->getCoeff(); // remise en fonction de l'utilisateur 
                }
                else {
                    $discountType = $item['product']->getDiscount(); // remise en fonction de l'utilisateur 
                }
                $discountPrice = $priceTTC - ($discountType / 100 * $priceTTC); // Prix avec réduction TTC
                $totalItem = $discountPrice * $item['quantity'];  // total pour les prix avec réduction TTC
                $total += $totalItem;
            }  
        }

        // set session attributes
        $this->session->set('total', $total); // on onvoie dans la session le totalTTC (prix) pour afficher le récapitulatif dans sur la page app_checkout_payment (CheckoutController)
   
        return $total;
    }
    
    /**
     * fonction qui calcul le total (prix) du panier HT
     *
     * @return float
     */
    public function getTotalHT() 
    {
        $totalHT = 0; // initialise le total à 0
        $panierData = $this->getFullPanier();

        // boucle pour avoir le total du panier avec réduction et sans réduction TTC
        foreach($panierData as $item) {

            if($item['product']->getDiscount() == NULL) { 
                $totalItem = $item['product']->getPrice() * $item['quantity']; // total pour les prix sans réduction HT
                $totalHT += $totalItem; 
            } else {
                if($this->getUser()) {
                    $discountType = $item['product']->getDiscount() + $this->getUser()->getCoeff(); // remise en fonction de l'utilisateur 
                }
                else {
                    $discountType = $item['product']->getDiscount(); // remise en fonction de l'utilisateur 
                }
                $discountPrice = $item['product']->getPrice() - ($discountType / 100 * $item['product']->getPrice()); // Prix avec réduction HT
                $totalItem = $discountPrice * $item['quantity'];  // total pour les prix avec réduction HT
                $totalHT += $totalItem;
            }  
        }

        // set session attributes
        $this->session->set('totalHT', $totalHT); // on onvoie dans la session le totalHT (prix) pour afficher le récapitulatif dans sur la page app_checkout_payment (CheckoutController)
   
        return $totalHT;
    }

     /**
     * fonction incrémenté un produit 
     *
     */
    public function increase(int $id) 
    {
        $panier = $this->session->get('panier', []); // Je vérifie s'il y a une donnée 'panier' dans ma session et par défaut si c'est vide c'est un tableau vide dans la variable $panier
        
        if(!empty($panier[$id])) { // Si le produit existe déjà dans le panier on rajoute on incrémente 
            $panier[$id]++;
        } else {
            $panier[$id] = 1; // Sinon on ajoute le produit 1 fois
        }

        $this->session->set('panier', $panier); // On sauvegarde dans la session l'état de notre panier actuel après modification
    }

     /**
     * fonction décrémenter un produit 
     *
     */
    public function remove(int $id) 
    {
        $panier = $this->session->get('panier', []); // Je vérifie s'il y a une donnée 'panier' dans ma session et par défaut si c'est vide c'est un tableau vide dans la variable $panier
        
        if(!empty($panier[$id])) { 
            if($panier[$id] > 1) { // Si le produit existe déjà et qu'il y en a plus de 1 dans le panier on décrémente
                $panier[$id]--;
            } else {
                unset($panier[$id]); // Sinon on le supprime
            }    
        }

        $this->session->set('panier', $panier); // On sauvegarde dans la session l'état de notre panier actuel après modification
    }

     /**
     * fonction pour vider mon panier 
     */
    public function clearPanier()
    {
        $this->session->remove('panier');
    }

    /**
     * fonction qui récupère le nombre de produit ajouté au panier
     *
     */
    public function TotalItemsCart() 
    {
         // Pour récupèrer le nombre total de mes produits pour afficher dans l'icône cart
         $panierData = $this->getFullPanier();
         $TotalItemsCart = 0; 
         foreach($panierData as $item) { // boucle pour récupèrer le nombre total de mes produits dans le panier 
             $TotalItemsCart += $item['quantity']; 
         }

        $this->session->set('TotalItemsCart', $TotalItemsCart); // On sauvegarde dans la session le nombre total de mes produits dans le panier
    }
}