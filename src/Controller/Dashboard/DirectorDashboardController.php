<?php

namespace App\Controller\Dashboard;

use App\Enum\RolesEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(RolesEnum::Director)]
class DirectorDashboardController extends AbstractController
{
	#[Route('/dashboard', name: 'app_dashboard')]
    #[Route('/dashboard', name: 'app_director_dashboard')]
    public function index(): Response
    {
        return $this->render('director_dashboard/index.html.twig', [
        ]);
    }
}
