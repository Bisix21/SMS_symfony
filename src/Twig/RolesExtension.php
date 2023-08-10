<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RolesExtension extends AbstractExtension
{
	public function getFunctions(): array
	{
		return [
			new TwigFunction('role', [$this, 'role'])
		];
	}

	public function role(string $role): string
	{
		return substr($role, 5);
	}
//todo make pretty render role list
}