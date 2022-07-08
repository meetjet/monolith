<?php

namespace App\Enums;

use Ajimoti\RolesAndPermissions\Helpers\BaseRole;
use BenSampo\Enum\Contracts\LocalizedEnum;

class Role extends BaseRole implements LocalizedEnum
{
    public const ROOT = 'root';
    public const ADMIN = 'admin';
    public const MANAGER = 'manager';
    public const EDITOR = 'editor';
    public const SUBSCRIBER = 'subscriber';

    protected static $useHierarchy = true;

    /**
     * Set available roles and their permissions.
     *
     * @return array
     */
    public static function permissions(): array
    {
        return [
            self::ROOT => [ // Permissions are inherited from lower roles.
            ],

            self::ADMIN => [ // Admin permissions should be here.
//                Permission::PROJECT_CREATE,
            ],

            self::MANAGER => [ // Manager permissions should be here.
            ],

            self::EDITOR => [ // Editor permissions should be here.
            ],

            self::SUBSCRIBER => [ // Subscriber permissions should be here.
            ],
        ];
    }
}
