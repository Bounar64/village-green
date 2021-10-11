<?php

namespace App\Controller\Admin;

use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/treasury", name="app_admin_treasury_")
 */
class TreasuryController extends AbstractController
{ 
    /**
     * @Route("/", name="account")
     */
    public function TreasuryAccount(OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findAll();
        $turnoverPart = $orderRepository->TurnoverPart();
        $turnoverPro = $orderRepository->TurnoverPro();
        
        $turnoverPart = ($turnoverPart[0][1] * 200);
        $turnoverPro = ($turnoverPro[0][1] * 400);

        return $this->render('admin/treasury/treasury_account.html.twig', [
            'order' => $order,
            'turnoverPart' => $turnoverPart,
            'turnoverPro' => $turnoverPro
        ]);
    }
}