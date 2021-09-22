<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderStepController extends AbstractController
{
    /**
     * fonction pour choix de la livraison et modification adresse
     * 
     * @Route("/shipping", name="app_shipping")
     */
    public function shipping(): Response
    {
        return $this->render('order_step/shipping.html.twig');
    }

    /**
     * fonction Pour payer choix mode de paiment + code promo et total panier 
     * 
     * @Route("/payment", name="app_payment")
     */
    public function payment(): Response
    {
        return $this->render('order_step/payment.html.twig');
    }

    /**
     * 
     * @Route("/validation", name="app_validation")
     */
    public function validation(): Response
    {
        return $this->render('order_step/validation.html.twig');
    }
}
