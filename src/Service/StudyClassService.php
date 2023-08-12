<?php

namespace App\Service;

use App\Entity\User;
use App\Enum\RolesEnum;
use App\Repository\UserRepository;

class StudyClassService
{
	public function __construct(
		protected UserRepository $userRepository
	)
	{
	}

	public function getStudents(): array
	{
		return $this->userRepository->selectUsersWithCallbackFilter(
			fn(User $user) => in_array(RolesEnum::Student, $user->getRoles())
				&& is_null($user->getStudyClass())
				&& !is_null($user->isVerified()));
	}
}