<?php

namespace App\Controller\Dashboard;

use App\Enum\RolesEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(RolesEnum::Admin)]
class AdminDashboardController extends AbstractController
{
	#[Route('/dashboard', name: 'app_dashboard')]
	#[Route('/admin/dashboard', name: 'app_admin_dashboard')]
	public function index(): Response
	{
		return $this->render('admin_dashboard/index.html.twig');
	}
}
