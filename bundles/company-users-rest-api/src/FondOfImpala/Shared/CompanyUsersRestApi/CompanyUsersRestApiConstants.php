<?php

declare(strict_types = 1);

namespace FondOfImpala\Shared\CompanyUsersRestApi;

interface CompanyUsersRestApiConstants
{
    /**
     * @var string
     */
    public const BASE_URL_APP = 'COMPANY_USER_REST_API:BASE_URL_APP';

    /**
     * @var string
     */
    public const BASE_URI = 'FOND_OF_IMPALA:COMPANY_USER_REST_API:BASE_URI';

    /**
     * @var string
     */
    public const PROTECTED_ROLES = 'FOND_OF_IMPALA:COMPANY_USER_REST_API:PROTECTED_ROLES';

    /**
     * @var array
     */
    public const PROTECTED_ROLES_DEFAULT = [
        'super_administration',
        'administration',
    ];
}
