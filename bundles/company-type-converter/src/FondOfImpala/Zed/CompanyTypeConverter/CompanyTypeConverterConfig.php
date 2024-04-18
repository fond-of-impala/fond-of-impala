<?php

namespace FondOfImpala\Zed\CompanyTypeConverter;

use FondOfImpala\Shared\CompanyTypeConverter\CompanyTypeConverterConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class CompanyTypeConverterConfig extends AbstractBundleConfig
{
    /**
     * @param string $companyType
     *
     * @return array<string>
     */
    public function getCompanyTypeDefaultRoleMapping(string $companyType = ''): array
    {
        $companyTypeDefaultRolesMapping = $this->get(CompanyTypeConverterConstants::COMPANY_TYPE_DEFAULT_ROLES_MAPPING);

        if ($companyType === '') {
            return $companyTypeDefaultRolesMapping;
        }

        if (!isset($companyTypeDefaultRolesMapping[$companyType])) {
            return [];
        }

        return $companyTypeDefaultRolesMapping[$companyType];
    }

    /**
     * @return array
     */
    public function getNonConvertibleRoleTypeKeys(): array
    {
        return $this->get(CompanyTypeConverterConstants::COMPANY_TYPE_NON_CONVERTIBLE_ROLE_TYPE_KEYS, []);
    }
}
