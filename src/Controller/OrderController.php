<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class OrderController extends AbstractController
{
    public function index(EntityManagerInterface $entityManager): Response
    {
        $orders = $entityManager->getRepository(Order::class)->findAll();
        return $this->render('orders/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $productId = $request->request->get('product_id');
        $product = $entityManager->getRepository(Product::class)->find($productId);

        if (!$product) {
            return new Response('Product not found', Response::HTTP_NOT_FOUND);
        }

        $orderParams = [
            'productNo' => $productId,
            'productName' => $request->request->get('productName'),
            'price' => '14.21'
        ];

        $order = new Order();
        $orderService = new orderService();
        $orderService->parseOrderParams($order, $orderParams);

        $entityManager->persist($order);
        $entityManager->flush();

        return new Response('Order added', Response::HTTP_CREATED);
    }
}
