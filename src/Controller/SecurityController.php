<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{  
    private $categoryRepository;
    private $subcategoryRepository;

    public function __construct(CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->subcategoryRepository = $subcategoryRepository;
    }
    
    /**
     * @Route("/login", name="app_login")
     */
    public function login() 
    {
        // Si l'on est connecté on ne peux pas accédé à la page login
        if ($this->getUser()) {

            $this->addFlash('danger', 'Vous êtes déjà connecté !');
            
            return $this->redirectToRoute('app_home');
        }
        else {
            return $this->redirectToRoute('app_home'); // Pour évité d'accéder au script du popover login 
        }

        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        return $this->render('security/login.html.twig', [
            'categories' => $categories, 
            'subcategory' => $subcategory
        ]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    /**
     * fonction pour se connecté ou s'inscrire lorsqu'on click sur commander
     *
     * @Route("/checkout_connection", name="app_checkout_connection")
     */
    public function connection(AuthenticationUtils $authenticationUtils)
    {
        // Si l'on est connecté on ne peux pas accédé à la page connection
        if ($this->getUser()) {

            $this->addFlash('danger', 'Vous êtes déjà connecté !');
            
            return $this->redirectToRoute('app_home');
        }

        $categories = $this->categoryRepository->findBy([], [], 9, null); // findBy($where, $orderBy, $limit, $offset);
        $subcategory = $this->subcategoryRepository->findAll('category');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/connection.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
            'categories' => $categories, 
            'subcategory' => $subcategory
        ]);
    }
}
