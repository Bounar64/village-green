<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\StatusRepository;
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
    private $statusRepository;
    private $orderRepository;

    public function __construct(CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository,
                                 ProductRepository $productRepository, StatusRepository $statusRepository, OrderRepository $orderRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->subcategoryRepository = $subcategoryRepository;
        $this->productRepository = $productRepository;
        $this->statusRepository = $statusRepository;
        $this->orderRepository = $orderRepository;
    }
    
    /**
     * fonction pour choix de la livraison et modification adresse
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
 
        $panierData =  $session->get('panierData'); // on récupère le panier complet avec les produits commandés
        $total = $session->get('total'); // on récupère le prix total
        $shippingType = $session->get('shippingType'); // on récupère le type de livraison

        $payment = $request->request->get('checkPayment'); // équivaut à $_POST["checkPayment"]
        $valider = $request->request->get('buttonPayment'); // équivaut à $_POST["valider"]
        
        if(isset($valider) && !empty($payment)) {
        
            // On commence la transaction au moment du paiement 
            // $manager->beginTransaction();
            // $manager->getConnection()->setAutoCommit(false); // désactive l'auto-commit par défaut à true
            
            $session->set('paymentType', $payment);
            return $this->redirectToRoute('app_checkout_validation');
        }
        
        return $this->render('checkout/payment.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'products' => $products,
            'items' => $panierData,
            'total' => $total,
            'shipping' => $shippingType,
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
        $total = $session->get('total'); // on récupère le prix total
        $shippingType = $session->get('shippingType'); // on récupère le type de livraison
        $paymentType = $session->get('paymentType'); // on récupère le type de paiement 
        
        $reference = ('#' . rand(1000, 9999)); // création d'un numéro de commande (référence) 
        $statusType = $status[0]; // on récupère l'objet de type app\entity\status, par défaut ce sera toujours cette valeur "en cours de traitement" id="1"
        
        $session->set('orderReference', $reference); // on set la référence de la commande
        

        // Création de la commande
        $order = new Order();
        $order->setReference($reference);
        $order->setTypePayment($paymentType);
        $order->setShipping($shippingType);
        $order->setTotal($total);
        $order->setDatePayment(new \DateTimeImmutable);
        $order->setUser($this->getUser());
        $order->setStatus($statusType);
        //Création du détail de la commande

        // Annulation de la transaction si un problème survient
        // $manager->getConnection()->rollBack();

        $manager->persist($order);
        $manager->flush();

        // sleep(8); // pour un effet de chargement
        //return $this->redirectToRoute('app_checkout_order_details'); 

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
    public function OrderDetailsCheck(SessionInterface $session): response
    {
        if (!$this->getUser()) {
            
            return $this->redirectToRoute('app_checkout_connection');
        }

        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');
        $products = $this->productRepository->findAll();
        $status = $this->statusRepository->findBy(['id' => 1], [], null, null);   

        $statusType = $status[0];
        $panierData =  $session->get('panierData'); // on récupère le panier complet avec les produits commandés
        $total = $session->get('total'); // on récupère le prix total
        $shippingType = $session->get('shippingType'); // on récupère le type de livraison
        $paymentType = $session->get('paymentType'); // on récupère le type de paiement

        return $this->render('checkout/order_details_check.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'products' => $products,
            'status'=> $statusType,
            'items' => $panierData,
            'total' => $total,
            'shipping' => $shippingType,
            'payment' => $paymentType
        ]);
    }

    /**
     * fonction pour télécharger la facture au format pdf
     *
    * @Route("/invoice", name="app_checkout_order_invoice", methods={"GET"})
     */
    public function downloadInvoicePDF(SessionInterface $session)
    {
        $order = $this->orderRepository->findBy(['reference' => $session->get('orderReference')], [], null, null);
        $panierData =  $session->get('panierData'); // on récupère le panier complet avec les produits commandés
        $total = $session->get('total'); // on récupère le prix total
        // // Configure Dompdf according to your needs
        // $pdfOptions = new Options();
        // $pdfOptions->set('isHtml5ParserEnabled', true);
        // $pdfOptions->set('isRemoteEnabled', true);
        // $pdfOptions->set('defaultFont', 'Montserrat');
        
        // // Instantiate Dompdf with our options
        // $dompdf = new Dompdf($pdfOptions);
        
        // // Retrieve the HTML generated in our twig file
        // $html = $this->renderView('checkout/pdf/invoice.html.twig');
        
        // // Load HTML to Dompdf
        // $dompdf->loadHtml($html);
        
        // // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        // $dompdf->setPaper('A4', 'portrait');

        // // Render the HTML as PDF
        // $dompdf->render();

        // // Output the generated PDF to Browser (force download)
        // $dompdf->stream("mypdf.pdf", [
        //     "Attachment" => false
        // ]);

        // return new Response('', 200, [
        //     'Content-Type' => 'application/pdf',
        // ]);

        return $this->render('checkout/pdf/invoice.html.twig', [
                'order' => $order,
                'items' => $panierData,
                'total' => $total
        ]);
    }
}
