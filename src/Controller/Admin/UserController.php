<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use App\Form\SearchFulltextType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\OrderRepository;
use App\Repository\StatusRepository;
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
    private $orderRepository;
    private $statusRepository;

    public function __construct(UserRepository $userRepository, OrderRepository $orderRepository, StatusRepository $statusRepository)
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->statusRepository = $statusRepository;
    }
    
    /**
     * @Route("/", name="list")
     */
    public function UserList(): Response
    {
        return $this->render('admin/users/users_list.html.twig', [
            'Listuser' => $this->userRepository->findAll()
        ]);
        
    }

    /**
     * @Route("/order_details", name="order_details")
     */
    public function UserOrderDetails(): Response
    {

        return $this->render('admin/users/user_order_details.html.twig', [
            'Listuser' => $this->userRepository->findAll(),
            'Order' => $this->orderRepository->findAll(),
            'Status' => $this->statusRepository->findAll()
            
        ]);
        
    }
}
    
