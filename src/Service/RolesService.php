<?php

namespace App\Service;

use App\Enum\RolesEnum;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RolesService
{
	public function __construct(
		private UrlGeneratorInterface           $urlGenerator,
		protected AuthorizationCheckerInterface $authorizationChecker,
	)
	{
	}

	public function roles(bool $isAdmin = false): array
	{
		$roles = [
			'Teacher' => RolesEnum::Teacher,
			'Student' => RolesEnum::Student,
			'Parent' => RolesEnum::Parents,
			'Moderator' => RolesEnum::Moderator,
			'Classmate' => RolesEnum::Classmate,
		];
		if ($isAdmin) {
			$roles['Director'] = RolesEnum::Director;
			$roles['Admin'] = RolesEnum::Admin;
		}
		return $roles;
	}

	//TODO refactor code
	public function handleRolesRedirect(): RedirectResponse
	{
		if ($this->authorizationChecker->isGranted(RolesEnum::Admin)) {
			return new RedirectResponse($this->urlGenerator->generate('app_admin_dashboard'));
		}
		if ($this->authorizationChecker->isGranted(RolesEnum::Director)) {
			return new RedirectResponse($this->urlGenerator->generate('app_director_dashboard'));
		}
		if ($this->authorizationChecker->isGranted(RolesEnum::Student)) {
			return new RedirectResponse($this->urlGenerator->generate('app_user_index'));
		}
		return new RedirectResponse($this->urlGenerator->generate('app_home'));
	}
}