<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ControllerService extends AbstractController
{
	public function addFlash(string $type, mixed $message): void
	{
		$type = explode('_', $type);
		parent::addFlash(strtolower($type[0]), sprintf($message, $type[1]));
	}
}