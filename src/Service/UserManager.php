<?php
namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    private $entityManager;
    private $passwordEncoder;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = new UserPasswordEncoderInterface();
    }

    public function createUser($username, $password)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
