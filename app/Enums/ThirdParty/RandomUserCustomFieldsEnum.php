<?php

namespace App\Enums\ThirdParty;

use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum RandomUserCustomFieldsEnum: string
{
    use UsefulEnums;
    case FullName = "full_name";
    case County = "country";
}
