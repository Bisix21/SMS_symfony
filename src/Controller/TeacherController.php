<?php

namespace App\Controller;

use App\Enum\RolesEnum;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(RolesEnum::Teacher)]
#[Route('/teacher')]
class TeacherController extends AbstractController
{
    #[Route('/', name: 'app_teacher')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('teacher/index.html.twig', [
            'teacherList' => $userRepository->getTeachers()
        ]);
    }

    #[Route('/{id}/show', name: 'app_teacher_show')]
	public function show(int $id, UserRepository $userRepository): Response
    {
			dd($userRepository->getTeacherWithClass($id));
		return $this->render('teacher/show.html.twig', [
			'teacher' => $userRepository->getTeacherWithClass($id),
		]);
	}
}
