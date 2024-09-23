<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Man
 * @method static static Woman
 * @method static static Others
 */
final class UserSex extends Enum
{
    const Man = "1";
    const Woman = "2";
    const Others = "3";
}