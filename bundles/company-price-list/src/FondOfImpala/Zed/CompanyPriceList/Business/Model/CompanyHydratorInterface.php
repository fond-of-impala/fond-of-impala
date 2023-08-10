<?php

namespace FondOfImpala\Zed\CompanyPriceList\Business\Model;

use Generated\Shared\Transfer\CompanyTransfer;

interface CompanyHydratorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function hydrate(CompanyTransfer $companyTransfer): CompanyTransfer;
}
