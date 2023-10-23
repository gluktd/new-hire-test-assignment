<?php

namespace App\Enums\ThirdParty;

enum RandomUserFieldsEnum: string
{
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
