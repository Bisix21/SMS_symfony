<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
public function __construct(
	protected Environment $twig
)
	{
	}

	/**
	 * @throws SyntaxError
	 * @throws RuntimeError
	 * @throws LoaderError
	 */
	public function handle(Request $request, AccessDeniedException $accessDeniedException):Response
	{
		// Render the 403 error page using Twig
		return new Response($this->twig->render('error/error_403.html.twig'), 403);
	}
}