<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner;

use FondOfImpala\Shared\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class CompanyUserCompanyAssignerConfig extends AbstractBundleConfig
{
    /**
     * @return array
     */
    public function getManufacturerCompanyTypeRoleMapping(): array
    {
        return $this->get(CompanyUserCompanyAssignerConstants::MANUFACTURER_COMPANY_TYPE_ROLE_MAPPING, []);
    }

    /**
     * @return array
     */
    public function getValidManufacturerCompanyRolesForAssignment(): array
    {
        return $this->get(CompanyUserCompanyAssignerConstants::VALID_MANUFACTURER_COMPANY_ROLES_FOR_ASSIGNMENT, []);
    }
}
