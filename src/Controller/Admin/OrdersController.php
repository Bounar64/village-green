<?php

namespace App\Controller\Admin;

use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/orders", name="app_admin_orders_")
 */
class OrdersController extends AbstractController
{ 
    /**
     * @Route("/", name="list")
     */
    public function OrderList(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findBy([], ['datePayment' => 'DESC'], null, null);

        $averageTimePart = $orderRepository->AverageTimePart();
        $averageTimePro = $orderRepository->AverageTimePro();

        $averageTimeAll = (($averageTimePart[0][1] + $averageTimePro[0][1]) / 2);

        return $this->render('admin/orders/orders_list.html.twig', [
            'Order' => $orders,
            'averageTimePart' => $averageTimePart[0][1],
            'averageTimePro' => $averageTimePro[0][1],
            'averageTimeAll' => $averageTimeAll
        ]);
    }
}