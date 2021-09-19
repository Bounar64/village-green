<?php

namespace App\Controller;

use App\Form\EditProfilUserType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * Pour afficher mon compte
     * 
     * @Route("/account", name="app_account", methods="GET")
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
     * @Route("account/edit", name="app_account_edit", methods={"GET", "POST"})
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
     * @Route("account/change-password", name="app_account_change_password", methods={"GET", "POST"})
     */
    public function changePassword(Request $request, EntityManagerInterface $manager): Response
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

        return $this->render('account/profil/change_password.html.twig', [
            'categories' => $categories,
            'subcategory' => $subcategory,
            'form' => $form->createView()
        ]);
    }

}
