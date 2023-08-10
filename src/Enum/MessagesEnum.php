<?php

namespace App\Enum;

enum MessagesEnum: string
{
	case SUCCESS_SAVED = 'Record is success saved!';
	case SUCCESS_UPDATE = 'Record is success updated!';
	case SUCCESS_DELETED = "Record is success deleted!";
	case WARNING_LOGIN_ALREADY = "You are logged in!";
	case INFO = "wws";
	case WARNING = "w";
	case ERROR = "s";
}
