<?php

namespace App\Service;

use App\Entity\User;
use App\Enum\RolesEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ControllerService extends AbstractController
{
	public function addFlash(string $type, mixed $message): void
	{
		$type = explode('_', $type);
		parent::addFlash(strtolower($type[0]), sprintf($message, $type[1]));
	}
}