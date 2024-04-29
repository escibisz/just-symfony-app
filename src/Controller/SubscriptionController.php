<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class SubscriptionController extends AbstractController
{
    public function activate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userId = $request->query->get('user_id');
        $user = $entityManager->getRepository(User::class)->find($userId);

        if (!$user) {
            return new Response('User not found', Response::HTTP_NOT_FOUND);
        }

        if ($user->isSubscribed()) {
            return new Response('User already subscribed', Response::HTTP_BAD_REQUEST);
        }

        $user->setSubscribed(true);
        $entityManager->flush();

        return new Response('Subscription activated', Response::HTTP_OK);
    }
}