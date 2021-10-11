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
        
        $turnoverPart = $turnoverPart[0][1]; // récupère C.A particulier TTC avec 200 commandes
        $turnoverPro = $turnoverPro[0][1]; // récupère C.A professionnel TTC avec 400 commandes

        $turnoverPartTTC = $turnoverPart; // total chiffre d'affaire particulier TTC 
        $turnoverPartHT = ($turnoverPart - (20 / 100 * $turnoverPart)); // total C.A Part HT 
        $turnoverProTTC = $turnoverPro; // total chiffre d'affaire professionnel TTC 
        $turnoverProHT = ($turnoverPro - (20 / 100 * $turnoverPro)); // total C.A Pro HT 

        return $this->render('admin/treasury/treasury_account.html.twig', [
            'order' => $order,
            'turnoverPartHT' => $turnoverPartHT,
            'turnoverProHT' => $turnoverProHT,
            'turnoverPartTTC' => $turnoverPartTTC,
            'turnoverProTTC' => $turnoverProTTC,
        ]);
    }
}