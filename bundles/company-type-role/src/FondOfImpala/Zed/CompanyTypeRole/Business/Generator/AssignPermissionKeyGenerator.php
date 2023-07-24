<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Generator;

use Generated\Shared\Transfer\CompanyRoleTransfer;

class AssignPermissionKeyGenerator implements AssignPermissionKeyGeneratorInterface
{
    /**
     * @var string
     */
    public const KEY_PREFIX = 'Assign';

    /**
     * @var string
     */
    public const KEY_SUFFIX = 'RolePermission';

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return string|null
     */
    public function generateByCompanyRole(CompanyRoleTransfer $companyRoleTransfer): ?string
    {
        $companyRoleName = $companyRoleTransfer->getName();

        if ($companyRoleName === null) {
            return null;
        }

        return sprintf(
            '%s%s%s',
            static::KEY_PREFIX,
            str_replace('_', '', ucwords($companyRoleName, '_')),
            static::KEY_SUFFIX,
        );
    }
}
