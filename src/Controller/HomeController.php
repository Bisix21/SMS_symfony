<?php

namespace App\Controller;

use App\Enum\RolesEnum;
use App\Factory\UserFactory;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
	public function __construct(
		protected $datetime = new DateTime()
	)
	{
	}

	#[Route('/', name: 'app_home')]
	public function index(UserFactory $factory): Response
	{
		$this->factory($factory);
		return $this->render('home/index.html.twig');
	}

	protected function factory(UserFactory $factory)
	{
		$factory->createUsers(
			'bisix21@gmail.com',
			'1111',
			'Bykhalets',
			'Serhii',
			'Volodymyrovych',
			$this->datetime->setDate(1997, 10,25),
			[
				RolesEnum::Admin,
				RolesEnum::Student,
				RolesEnum::Director,
				RolesEnum::Teacher,
				RolesEnum::Classmate,
			],
		);
		$factory->createUsers(
			'tester@gmail.com',
			'1111',
			'Bykhalets',
			'Victor',
			'Volodymyrovych',
			$this->datetime->setDate(2005, 11,23),
			[
				RolesEnum::Student,
				RolesEnum::Moderator,
			],
		);
	}
}
