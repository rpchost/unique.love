<?php

declare(strict_types=1);

namespace Unilo\Keys;

class CacheKeys
{
    public const string USER_DATA = 'unilo_user_{guard}_{id}';
    public const string USER_TOKEN = 'unilo_user_token_{guard}_{id}';
}
