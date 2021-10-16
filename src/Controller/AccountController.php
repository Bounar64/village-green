<?php

namespace App\Controller;

use App\Form\EditProfilUserType;
use App\Repository\OrderRepository;
use App\Form\ChangePasswordFormType;
use App\Repository\StatusRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\CodePromoRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use App\Repository\OrderDetailsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/account")
 */
class AccountController extends AbstractController
{
    private $categoryRepository;
    private $subcategoryRepository;
    private $orderRepository;
    private $orderdetailsRepository;
    private $productRepository;
    private $statusRepository;
    private $codePromoRepository;

    public function __construct(CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository, 
                                OrderRepository $orderRepository, OrderDetailsRepository $orderdetailsRepository, 
                                ProductRepository $productRepository, StatusRepository $statusRepository, CodePromoRepository $codePromoRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->subcategoryRepository = $subcategoryRepository;
        $this->orderRepository = $orderRepository;
        $this->orderdetailsRepository = $orderdetailsRepository;
        $this->productRepository = $productRepository;
        $this->statusRepository = $statusRepository;
        $this->codePromoRepository = $codePromoRepository;
    }

    /**
     * Pour afficher mon compte
     * 
     * @Route("", name="app_account", methods="GET")
     */
    public function Show(): Response
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        return $this->render('account/account.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
        ]);
    }

    /**
     * Pour éditer mes données personnelles
     * 
     * @Route("/edit", name="app_account_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EntityManagerInterface $manager): Response
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); 
        $subcategory = $this->subcategoryRepository->findAll('category');

        $user = $this->getUser(); // $this->getUser() récupère l'utilisateur actuellement connecté
        $form = $this->createForm(EditProfilUserType::class, $user); 
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $manager->flush();
            $this->addFlash('success', 'Profil mis à jour !');
            return $this->redirectToRoute('app_account');  
        }

        return $this->render('account/profil/edit_profil.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

    /**
     * Pour modifier mon mot de passe
     * 
     * @Route("/change-password", name="app_account_change_password", methods={"GET", "POST"})
     */
    public function changePassword(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); 
        $subcategory = $this->subcategoryRepository->findAll('category');

        $user = $this->getUser(); // $this->getUser() récupère l'utilisateur actuellement connecté
        $form = $this->createForm(ChangePasswordFormType::class, $user, [ // on récupère l'options pour afficher le currentPassword
            'current_password_is_required' => true
        ]); 
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $hashedPassword = $passwordHasher->hashPassword(
                $form['PlainPassword']->getData()
            ); // ou l'écrire $form->get('Plainpassword')->getData() == récupère le nouveau mot de passe et on le hash
            
            $user->setPassword($hashedPassword); // on envoie le nouveau mot de passe hasher
            $manager->flush();

            $this->addFlash('success', 'Mot de passe mise à jour !');
            return $this->redirectToRoute('app_account');  
        }

        return $this->render('account/profil/change_password.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

    /**
     * Pour voir ses commandes
     * 
     * @Route("/orders", name="app_account_orders", methods={"GET", "POST"})
     */
    public function Order() 
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); 
        $subcategory = $this->subcategoryRepository->findAll('category');
        $order = $this->orderRepository->findBy(['user' => $this->getUser()], ['datePayment' => 'DESC'], null, null); // récupère les commandes par rapport à l'utilisateur connecté
        
        $orderdetails = $this->orderdetailsRepository->findBy(['orders' => $order], [], null, null); // récupère le détails des commandes par rapport à la commande
    
        // on récupère toute les données de l'entité CodePromo via l'id du proxy 
        foreach($order as $value) {
            $promo = $value->getPromo();
            // si différent de null on récupère l'id 
            if($promo != null) {    
                $promoId = $value->getPromo()->getId();
                $this->codePromoRepository->findBy(['id' => $promoId], [], null, null);
            }   
        }
        
        foreach($orderdetails as $value) {
            $productId = $value->getId(); // réupère l'id du produit (seule donnée récupéré)
            $this->productRepository->findBy(['id' => $productId], [], null, null);  // ensuite avec l'id du produit on re récupère toute les infos des produits en question
            $statusId = $value->getOrders()->getStatus()->getId(); // réupère l'id du status (seule donnée récupéré)
            $this->statusRepository->findBy(['id' => $statusId], [], null, null); // ensuite avec l'id du produit on re récupère toute les infos des produits en question
        }
        // avec le foreach notre orderdetails récupère toute les infos nécessaires 

        return $this->render('account/orders/orders.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'order' => $order,
            'orderdetails' => $orderdetails
        ]);
        
    }
}
