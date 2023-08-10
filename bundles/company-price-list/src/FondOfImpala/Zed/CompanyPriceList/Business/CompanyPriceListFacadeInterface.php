<?php

namespace FondOfImpala\Zed\CompanyPriceList\Business;

use Generated\Shared\Transfer\CompanyTransfer;

interface CompanyPriceListFacadeInterface
{
    /**
     * Specification:
     *  - Hydrate company with assigned price list
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function hydrateCompany(CompanyTransfer $companyTransfer): CompanyTransfer;
}
