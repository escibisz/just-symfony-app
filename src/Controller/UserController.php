<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    public function showProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userId = $request->query->get('id');
        $user = $entityManager->getRepository(User::class)->find($userId);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    public function savePassword(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userId = $request->request->get('user_id');
        $newPassword = $request->request->get('new_password');
        $user = $entityManager->getRepository(User::class)->find($userId);
        $user->setPassword($newPassword);
        $entityManager->flush();

        return new Response('Password updated successfully');
    }
}
