<?php

namespace App\Service;

use App\Enum\RolesEnum;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RolesService
{
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
	public function handleRolesRedirect($authChecker, $urlGenerator): RedirectResponse
	{
		if ($authChecker->isGranted(RolesEnum::Admin)) {
			return new RedirectResponse($urlGenerator->generate('app_admin_dashboard'));
		}
		if ($authChecker->isGranted(RolesEnum::Director)) {
			return new RedirectResponse($urlGenerator->generate('app_director_dashboard'));
		}
		if ($authChecker->isGranted(RolesEnum::Student)) {
			return new RedirectResponse($urlGenerator->generate('app_user_index'));
		}
		return new RedirectResponse($urlGenerator->generate('app_home'));
	}
}