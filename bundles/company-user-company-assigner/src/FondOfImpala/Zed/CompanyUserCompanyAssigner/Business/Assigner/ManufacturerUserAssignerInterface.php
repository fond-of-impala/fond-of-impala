<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Assigner;

use Generated\Shared\Transfer\CompanyUserTransfer;

interface ManufacturerUserAssignerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $manufacturerUserTransfer
     *
     * @return void
     */
    public function assignToNonManufacturerCompanies(CompanyUserTransfer $manufacturerUserTransfer): void;
}
