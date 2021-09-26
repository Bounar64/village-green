<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\EditShippingAddressType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
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
     * fonction pour choix de la livraison et modification adresse
     * 
     * @Route("/checkout_shipping", name="app_checkout_shipping")
     */
    public function shipping(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        $user = $this->getUser(); // $this->getUser() récupère l'utilisateur actuellement connecté
        $form = $this->createForm(EditShippingAddressType::class, $user); // on passe ce form pour éditer seulement l'adresse de livraison
        
        $form->handleRequest($request);

        $shipping = $request->request->get('checkShipping'); // équivaut à $_POST["checkShipping"]
        $valider = $request->request->get('valider'); // équivaut à $_POST["valider"]
        
        
        if(isset($valider) && !empty($valider)) {

            $session->set('shippingType', $shipping);

            return $this->redirectToRoute('app_checkout_payment');  
        }

        if($form->isSubmitted() && $form->isValid()) {
            
            $manager->flush();

            // dd($form->getData());
            // $request->query->set('userLastName', $user->getLastName());

            return $this->redirectToRoute('app_checkout_shipping');  
        }
        
        return $this->render('checkout/shipping.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * fonction Pour payer choix mode de paiment + code promo et total panier 
     * 
     * @Route("/checkout_payment", name="app_checkout_payment")
     */
    public function payment(SessionInterface $session): Response
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');
        $products = $this->productRepository->findAll();  
 
        $panierData =  $session->get('panierData'); // on récupère le panier complet avec les produits commandés
        $total = $session->get('total'); // on récupère le prix total
        $ShippingType = $session->get('shippingType'); // on récupère le type de livraison 
        
        return $this->render('checkout/payment.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'products' => $products,
            'items' => $panierData,
            'total' => $total,
            'shipping' => $ShippingType         
        ]);
    }

    /**
     * 
     * @Route("/checkout_validation", name="app_checkout_validation")
     */
    public function validation(Request $request, SessionInterface $session): Response
    {
        $payment = $request->request->get('checkPayment'); // équivaut à $_POST["checkPayment"]
        $valider = $request->request->get('buttonPayment1'); // équivaut à $_POST["valider"]
        
        if(isset($valider) && !empty($valider)) {
            
            $session->set('paymentType', $payment);
            return $this->redirectToRoute('app_checkout_payment');  
        }

        $order = new Order();
        $order->setShipping('1');
        $orderDetails = new OrderDetails();

        // $formCheckout = $this->createForm(CheckoutType::class, $order);
        // $formOrderDetails = $this->createForm(OrderDetailsType::class, $orderDetails);

        // $formCheckout->handleRequest($request);
        // $formOrderDetails->handleRequest($request);

        return $this->render('checkout/validation.html.twig');
    }
}
