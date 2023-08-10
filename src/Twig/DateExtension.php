<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DateExtension extends AbstractExtension
{
	public function getFunctions(): array
	{
		return [
			new TwigFunction('array_to_string_date', [$this, 'arrayToStringDate'])
		];
	}

	public function arrayToStringDate(array $date): string
	{
		return  $date['year'] . '-' . $date['month'] . '-' . $date['day'];
	}
}