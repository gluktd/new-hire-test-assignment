<?php

namespace App\Enums\ThirdParty;

use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum RandomUserFieldsEnum: string
{
    use UsefulEnums;
    case Gender = "gender";
    case Email = "email";
    case Login = "login";
    case Registered = "registered";
    case Dob = "dob";
    case Phone = "phone";
    case Cell = "cell";
    case Id = "id";
    case Picture = "picture";
    case Nat = "nat";
}
