<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper;

use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyRoleNameMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $manufacturerUserTransfer
     *
     * @return string|null
     */
    public function fromManufacturerUser(CompanyUserTransfer $manufacturerUserTransfer): ?string;
}
