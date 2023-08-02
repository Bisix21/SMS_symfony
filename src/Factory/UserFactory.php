<?php

namespace App\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserFactory
{
	public function __construct(
		protected EntityManagerInterface $entityManager,
		protected UserRepository         $userRepository
	)
	{
	}

	public function createUsers(
		string             $email,
		string             $password,
		string             $first_name,
		string             $name,
		string             $sur_name,
		\DateTimeInterface $birthday,
		array              $roles = [],
	): void
	{
		if (!$this->checkUserExist($email)) {
			$user = new User();
			$user->setEmail($email);
			$user->setPassword(password_hash($password, PASSWORD_BCRYPT));
			$user->setRoles($roles);
			$user->setFirstName($first_name);
			$user->setName($name);
			$user->setSurName($sur_name);
			$user->setBirthday($birthday);
			$this->entityManager->persist($user);
			$this->entityManager->flush();
		}
	}

	protected function checkUserExist($email): bool
	{
		$user = $this->userRepository->findOneBy(['email' => $email]);
		return $user !== null;
	}
}