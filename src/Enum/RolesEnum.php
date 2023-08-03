<?php

namespace App\Enum;

enum RolesEnum: string
{
	const Admin = "ROLE_ADMIN";
	const Director = "ROLE_DIRECTOR";
	const Teacher = "ROLE_TEACHER";
	const Parents = "ROLE_PARENT";
	const Student = "ROLE_STUDENT";
	const Moderator = "ROLE_MODERATOR";
	const User = "ROLE_USER";
	const Classmate = "ROLE_CLASSMATE";
}