<?php

namespace App\Enums\ThirdParty;

use LaracraftTech\LaravelUsefulAdditions\Traits\UsefulEnums;

enum RandomUserVersionEnum: string
{
    use UsefulEnums;
    case V1_3 = "v1.3";
    case V1_4 = "v1.4";
}
