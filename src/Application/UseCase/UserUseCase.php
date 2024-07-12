<?php

namespace App\Application\UseCase;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserUseCase
{
    private UserRepositoryInterface $userRepository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserRepositoryInterface $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function createUser(string $email, string $plainPassword, array $roles = []): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setRoles($roles);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user);

        return $user;
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }
}
