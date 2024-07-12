<?php

namespace App\Controller;

use App\Application\UseCase\CreateOrder;
use App\Application\UseCase\GetOrders;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/orders', name: 'order_list', methods: ['GET'])]
    public function list(GetOrders $getOrders): Response
    {
        $orders = $getOrders->execute();
        return $this->render('order/list.html.twig', ['orders' => $orders]);
    }

    #[Route('/orders/create', name: 'order_create', methods: ['GET', 'POST'])]
    public function create(Request $request, CreateOrder $createOrder): Response
    {
        if ($request->isMethod('POST')) {
            $order = $createOrder->execute(
                $request->request->get('customerName'),
                $request->request->get('address'),
                $request->request->get('items')
            );
            return $this->redirectToRoute('order_list');
        }

        return $this->render('order/create.html.twig');
    }
}
