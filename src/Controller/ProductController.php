<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    public function getListForTable(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager->createQuery('SELECT p FROM App\Entity\Product p')->getResult();
        return $this->render('products/list.html.twig', [
            'products' => $products,
        ]);
    }
}
