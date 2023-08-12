<?php

namespace App\Controller;

use App\Enum\RolesEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(RolesEnum::Teacher)]
class TeacherDashboardController extends AbstractController
{
	#[Route('/dashboard', name: 'app_dashboard')]
    #[Route('/teacher/dashboard', name: 'app_teacher_dashboard')]
    public function index(): Response
    {
        return $this->render('teacher_dashboard/index.html.twig', [
            'controller_name' => 'TeacherDashboardController',
        ]);
    }
}
