<?php

namespace App\Controller;

use Exception;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Order;
use App\Form\CodePromoType;
use App\Entity\OrderDetails;
use App\Repository\OrderRepository;
use App\Repository\StatusRepository;
use App\Form\EditShippingAddressType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\CodePromoRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use App\Repository\OrderDetailsRepository;
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
    private $statusRepository;
    private $orderRepository;
    private $codepromoRepository;
    private $orderdetailsRepository;

    public function __construct(CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository,ProductRepository $productRepository, 
                                StatusRepository $statusRepository, OrderRepository $orderRepository,CodePromoRepository $codepromoRepository,
                                OrderDetailsRepository $orderdetailsRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->subcategoryRepository = $subcategoryRepository;
        $this->productRepository = $productRepository;
        $this->statusRepository = $statusRepository;
        $this->orderRepository = $orderRepository;
        $this->codepromoRepository = $codepromoRepository;
        $this->codepromoRepository = $codepromoRepository;
        $this->orderdetailsRepository = $orderdetailsRepository;
    }
    
    /**
     * fonction pour le choix de la livraison et modification de l'adresse
     * 
     * @Route("/checkout_shipping", name="app_checkout_shipping")
     */
    public function shipping(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
        if (!$this->getUser()) {
            
            return $this->redirectToRoute('app_checkout_connection');
        }

        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        $user = $this->getUser(); // $this->getUser() récupère l'utilisateur actuellement connecté
       
        $form = $this->createForm(EditShippingAddressType::class, $user); // on passe ce form pour éditer seulement l'adresse de livraison
        $form->handleRequest($request);

        $shipping = $request->request->get('checkShipping'); // équivaut à $_POST["checkShipping"]
        $valider = $request->request->get('valider'); // équivaut à $_POST["valider"]
        $error = false; // error vaut false par défaut 

        if(isset($valider) && !empty($shipping)) {

            $session->set('shippingType', $shipping);
            return $this->redirectToRoute('app_checkout_payment');   
        
        }elseif(isset($valider) && empty($shipping)) {
            
            $error = true; // s'il l'utilisateur ne coche pas un choix de livraison une erreur lui sera affiché dans twig via error
        }

        // validation pour la modification de l'addresse de l'utilisateur
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
            'error' => $error
        ]);
    }

    /**
     * fonction Pour payer choix mode de paiment + code promo et total panier 
     * 
     * @Route("/checkout_payment", name="app_checkout_payment")
     */
    public function payment(Request $request, SessionInterface $session, EntityManagerInterface $manager): Response
    {
        if (!$this->getUser()) {
            
            return $this->redirectToRoute('app_checkout_connection');
        } 

        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');
        $products = $this->productRepository->findAll();  

        $form = $this->createForm(CodePromoType::class);
        $form->handleRequest($request);
        $error = 0; // error vaut 0 par défaut

        if($form->isSubmitted() && $form->isValid()) {
            
            $codeUser = strtoupper($form['codepromo']->getData()); // on récupère le code promo de entré par l'utilisateur en majuscule ("strtoupper")
            $codepromo = $this->codepromoRepository->findBy(['codePromo' => $codeUser], [], null, null); // on récupère le code promo de la base s'il correspond au code user
            
            if($codepromo === []) { // si la correspondance n'existe on aura un tableau vide donc une erreur $error = ce code n'existe pas
                $error = 1;
                $codepromo = null; // le codepromo faudra donc null 
                $session->set('codepromo', $codepromo); // on set cet valeur null
            }elseif($codepromo[0]->getActived() == false) { // si cela correspond mais que le code est désactivé au aura une erreur $errorExp = ce code a expiré.
                $error = 3;
                $codepromo = null;
                $session->set('codepromo', $codepromo);
            }
            else{
                $error = 2; // Sinon error vaut 2 donc message = Code valide
                $codepromo = $codepromo[0]; // on récupère le code promo
                $session->set('codepromo', $codepromo); // on set ce code promo
            }
        } 

        $panierData =  $session->get('panierData'); // on récupère le panier complet avec les produits commandés
        $total = $session->get('total'); // on récupère le prix total
        $shippingType = $session->get('shippingType'); // on récupère le type de livraison

        $payment = $request->request->get('checkPayment'); // équivaut à $_POST["checkPayment"]
        $valider = $request->request->get('buttonPayment'); // équivaut à $_POST["valider"]
        

        if(isset($valider) && !empty($payment)) {


            $session->set('paymentType', $payment);
            $session->set('newTotal', $valider);
            return $this->redirectToRoute('app_checkout_validation');
        }
        
        $codepromo = $session->get('codepromo'); // on récupère l'entité codePromo utilisé
        // au chargement de la page code codePromoName et codePromoValue sont null (pas de get sur null)
        if($codepromo != null) {
            $codePromoName = $codepromo->getCodePromo(); 
            $codePromoValue = intval($codepromo->getCodeValue());
        }else {
            $codePromoName = ''; 
            $codePromoValue = '';
        }
        
        return $this->render('checkout/payment.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'products' => $products,
            'items' => $panierData,
            'total' => $total,
            'shipping' => $shippingType,
            'formPromo' => $form->createView(),
            'codePromoName' => $codePromoName,
            'codePromoValue' => $codePromoValue,
            'error' => $error
        ]);
    }

    /**
     * 
     * @Route("/checkout_validation", name="app_checkout_validation")
     */
    public function validation(SessionInterface $session, EntityManagerInterface $manager): response
    {
        if (!$this->getUser()) {
            
            return $this->redirectToRoute('app_checkout_connection');
        }

        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');
        $products = $this->productRepository->findAll();   
        $status = $this->statusRepository->findBy(['id' => 1], [], null, null);   

        $panierData =  $session->get('panierData'); // on récupère le panier complet avec les produits commandés
        $total = $session->get('total'); // on récupère le prix total TTC
        $newTotal = $session->get('newTotal'); // on récupère le prix total TTC
        $shippingType = $session->get('shippingType'); // on récupère le type de livraison
        $paymentType = $session->get('paymentType'); // on récupère le type de paiement 
        
        $reference = ('#' . rand(1000, 9999)); // création d'un numéro de commande (référence) 
        $statusType = $status[0]; // on récupère l'objet de type app\entity\status, par défaut ce sera toujours cette valeur "en cours de traitement" id="1"
        $session->set('orderReference', $reference); // on set la référence de la commande
        $codepromo = $session->get('codepromo');
        
        
        // On commence la transaction au moment du paiement 
        $manager->beginTransaction();
                
        // Création de la commande
        $order = new Order();
        $order->setReference($reference);
        $order->setTypePayment($paymentType);
        $order->setShipping($shippingType);
        $order->setTotal($newTotal);
        $order->setDatePayment(new \DateTimeImmutable);
        $order->setUser($this->getUser());
        $order->setStatus($statusType);
        $order->setPromo($codepromo);
        
        $manager->persist($order);

        // Création du détail de la commande
        foreach($panierData as $value) {
            $product = $value['product']; // On récupère le produit du panier, mais le supplier via le proxy affiche que l'id (problème de sessions)
            $ProductOrder = $this->productRepository->find($product->getId());  // on re récupère toute les infos du produit en question
            $quantitiesOrder = $value['quantity']; // on récupère la quantité
            
            $orderDetails = new OrderDetails();
            $orderDetails->setOrders($order);
            $orderDetails->setProduct($ProductOrder);
            $orderDetails->setQuantity($quantitiesOrder);

            //$order->addOrderDetail($orderDetails);
        }

        $manager->persist($orderDetails);

        try {
            // faire un commit avant le flush
            $manager->getConnection()->commit();
            $manager->flush();
            $manager->clear();
        } catch(Exception $e) {
            //Annulation de la transaction si un problème survient
            $manager->getConnection()->rollBack();
            $manager->close();
            throw $e;
        }

        header( "Refresh:8; /checkout_orders_details", true, 303); // pour un effet de chargement

        return $this->render('checkout/validation.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'products' => $products,
            'items' => $panierData,
            'total' => $total,
            'shipping' => $shippingType,
            'payment' => $paymentType,
        ]);
    }

    /**
     * 
     * @Route("/checkout_orders_details", name="app_checkout_order_details")
     */
    public function OrderDetailsCheck(SessionInterface $session): Response
    {
        if (!$this->getUser()) {
            
            return $this->redirectToRoute('app_checkout_connection');
        }

        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');
        $products = $this->productRepository->findAll();
        $status = $this->statusRepository->findBy(['id' => 1], [], null, null);

        // $lastOrder = $this->orderRepository->findBy(['reference' => $session->get('orderReference')], [], null, null);
        // $orderdetails = $this->orderdetailsRepository->findBy(['orders' => $lastOrder ], [], null, null); 
    
        $statusType = $status[0];
        $panierData =  $session->get('panierData'); // on récupère le panier complet avec les produits commandés
        $total = $session->get('total'); // on récupère le prix total
        $shippingType = $session->get('shippingType'); // on récupère le type de livraison
        $paymentType = $session->get('paymentType'); // on récupère le type de paiement
        $codepromo = $session->get('codepromo'); 

        return $this->render('checkout/order_details_check.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'products' => $products,
            'status'=> $statusType,
            'items' => $panierData,
            'total' => $total,
            'shipping' => $shippingType,
            'payment' => $paymentType,
            'codepromo' => $codepromo
        ]);
    }

    /**
     * fonction pour télécharger la facture au format pdf
     *
     * @Route("/invoice_download", name="app_download_invoice", methods={"GET"})
     */
    public function downloadInvoicePDF(SessionInterface $session)
    {
        $order = $this->orderRepository->findBy(['reference' => $session->get('orderReference')], [], null, null);
        $panierData =  $session->get('panierData'); // on récupère le panier complet avec les produits commandés
        $total = $session->get('total'); // on récupère le prix total TTC
        $totalHT = $session->get('totalHT'); // on récupère le prix total HT
        $shippingType = $session->get('shippingType');
        // // Configure Dompdf according to your needs
        // $pdfOptions = new Options();
        // $pdfOptions->set('isHtml5ParserEnabled', true);
        // $pdfOptions->set('isRemoteEnabled', true);
        // $pdfOptions->set('defaultFont', 'Montserrat');
        
        // // Instantiate Dompdf with our options
        // $dompdf = new Dompdf($pdfOptions);
        
        // // Retrieve the HTML generated in our twig file
        // $html = $this->renderView('checkout/pdf/invoice.html.twig', [
        //         'order' => $order,
        //         'items' => $panierData,
        //         'total' => $total
        // ]);
        
        // // Load HTML to Dompdf
        // $dompdf->loadHtml($html);
        
        // // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        // $dompdf->setPaper('A4', 'portrait');

        // // Render the HTML as PDF
        // $dompdf->render();

        // // Output the generated PDF to Browser (force download)
        // $dompdf->stream("facture.pdf", [
        //     "Attachment" => true
        // ]);

        // return new Response('', 200, [
        //     'Content-Type' => 'application/pdf',
        // ]);

        return $this->render('checkout/pdf/invoice.html.twig', [
                'order' => $order,
                'items' => $panierData,
                'total' => $total,
                'totalHT' => $totalHT,
                'shipping' => $shippingType
        ]);
    }

    /**
     * fonction pour affiché ("imprimer") la facture au format pdf
     *
     * @Route("/invoice_print", name="app_print_invoice", methods={"GET"})
     */
    public function printInvoicePDF(SessionInterface $session)
    {
        $order = $this->orderRepository->findBy(['reference' => $session->get('orderReference')], [], null, null);
        $panierData =  $session->get('panierData'); // on récupère le panier complet avec les produits commandés
        $total = $session->get('total'); // on récupère le prix total TTC
        $totalHT = $session->get('totalHT'); // on récupère le prix total HT
        $shippingType = $session->get('shippingType');
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('defaultFont', 'Montserrat');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('checkout/pdf/invoice.html.twig', [
                'order' => $order,
                'items' => $panierData,
                'total' => $total,
                'totalHT' => $totalHT,
                'shipping' => $shippingType

        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("FACTURE.pdf", [
            "Attachment" => false
        ]);

        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
