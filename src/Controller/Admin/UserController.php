<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use App\Form\SearchFulltextType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/user", name="app_admin_user_")
 */
class UserController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    /**
     * @Route("/", name="list")
     */
    public function UserList(): Response
    {
        return $this->render('admin/users/list_user.html.twig', [
            'Listuser' => $this->userRepository->findAll()
        ]);
        
    }
}
    
