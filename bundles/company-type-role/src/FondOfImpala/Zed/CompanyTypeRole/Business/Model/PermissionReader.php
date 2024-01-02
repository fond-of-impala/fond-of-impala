<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Model;

use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class PermissionReader implements PermissionReaderInterface
{
    protected CompanyTypeRoleConfig $config;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig $config
     */
    public function __construct(CompanyTypeRoleConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return array<string>
     */
    public function getCompanyTypeRolePermissionKeys(
        CompanyTypeTransfer $companyTypeTransfer,
        CompanyRoleTransfer $companyRoleTransfer
    ): array {
        return $this->config->getPermissionKeys(
            $companyTypeTransfer->getName(),
            $companyRoleTransfer->getName(),
        );
    }
}
