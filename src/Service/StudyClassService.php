<?php

namespace App\Service;

use App\Entity\StudyClass;
use App\Entity\User;
use App\Enum\RolesEnum;
use App\Repository\StudyClassRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class StudyClassService
{
	public function __construct(
		protected UserRepository         $userRepository,
		protected StudyClassRepository   $studyClassRepository,
		protected EntityManagerInterface $entityManager
	)
	{
	}

	protected function getStudents(): array
	{
		return $this->userRepository->selectUsersWithCallbackFilter(
			fn(User $user) => in_array(RolesEnum::Student, $user->getRoles())
				&& is_null($user->getStudyClass())
				&& !is_null($user->isVerified()));
	}

	protected function getClassmates(): array
	{
		return $this->userRepository->selectUsersWithCallbackFilter(
			fn(User $user) => in_array(RolesEnum::Classmate, $user->getRoles())
				&& is_null($user->getStudyClass())
				&& !is_null($user->isVerified()));
	}

	public function saveData( $students,  $classmate, StudyClass $studyClass, bool $persist = false): void
	{
		$this->studyClassRepository->addStudents($students, $studyClass, $this->userRepository);
		$this->studyClassRepository->addClassmate($classmate, $studyClass, $this->userRepository);
		if ($persist) {
			$this->entityManager->persist($studyClass);
		}
		$this->entityManager->flush();
	}

	public function getStudentsAndClassmate(): array
	{
		return [
			'student' => $this->getStudents(),
			'classmate' => $this->getClassmates(),
		];
	}
}