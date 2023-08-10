<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DirectorDashboardController extends AbstractController
{
    #[Route('/director/dashboard', name: 'app_director_dashboard')]
    public function index(): Response
    {
        return $this->render('director_dashboard/index.html.twig', [
        ]);
    }
}
