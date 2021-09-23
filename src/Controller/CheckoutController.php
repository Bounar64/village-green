<?php

namespace App\Controller;

use App\Repository\StatusRepository;
use App\Form\EditShippingAddressType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    private $categoryRepository;
    private $subcategoryRepository;
    private $productRepository;
    private $statusRepository;

    public function __construct(CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository, ProductRepository $productRepository, StatusRepository $statusRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->subcategoryRepository = $subcategoryRepository;
        $this->productRepository = $productRepository;
        $this->statusRepository = $statusRepository;
    }
    
    /**
     * fonction pour choix de la livraison et modification adresse
     * 
     * @Route("/checkout_shipping", name="app_checkout_shipping")
     */
    public function shipping(Request $request): Response
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');
        $products = $this->productRepository->findAll();

        $user = $this->getUser(); // $this->getUser() récupère l'utilisateur actuellement connecté
        $form = $this->createForm(EditShippingAddressType::class, $user); // on passe ce form pour éditer seulement l'adresse de livraison cela en passant l'option en plus 
        $form->handleRequest($request);

        return $this->render('checkout/shipping.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

    /**
     * fonction Pour payer choix mode de paiment + code promo et total panier 
     * 
     * @Route("/checkout_payment", name="app_checkout_payment")
     */
    public function payment(): Response
    {
        return $this->render('checkout/payment.html.twig');
    }

    /**
     * 
     * @Route("/checkout_validation", name="app_checkout_validation")
     */
    public function validation(): Response
    {
        return $this->render('checkout/validation.html.twig');
    }
}
