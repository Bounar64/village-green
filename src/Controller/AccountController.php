<?php

namespace App\Controller;

use App\Form\EditProfilType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/account")
 */
class AccountController extends AbstractController
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
     * @Route("", name="app_account_user")
     */
    public function Show(): Response
    {
        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        // $user = $this->getUser(); // $this->getUser() récupère l'utilisateur actuellement connecté
        // $form = $this->createForm(EditProfilType::class, $user); 
        // $form->handleRequest($request);

        // if($form->isSubmitted() && $form->isValid()) {

        //     $manager->persist($user);
        //     $manager->flush();
        //     $this->addFlash('success', 'Profil mis à jour !');
        //     return $this->redirectToRoute('app_account_user');  
        // }
        // elseif($form->isSubmitted() && !$form->isValid()) {

        //     $this->addFlash('danger', 'Une erreur est survenue lors de l\'envoi du formulaire.');
        //     return $this->redirectToRoute('app_account_user'); 
        // }

        return $this->render('account/account_user.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
        ]);
    }

    // /**
    //  * @Route("/edit", name="app_profil_user_edit")
    //  */
    // public function editProfil(): Response
    // {
    //     // Si l'on est connecté on ne peux pas accédé à la page login
    //     if ($this->getUser()) {
            
    //         return $this->redirectToRoute('app_profil_user');
    //     }
    //     else {
    //         return $this->redirectToRoute('app_home'); // Pour évité d'accéder au script d'édition même sans login
    //     }

    //     return $this->render('user/page/edit_profil.html.twig');
    // }

}
