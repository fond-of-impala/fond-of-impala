<?php

namespace FondOfImpala\Zed\CompanyType\Persistence\Mapper;

use Generated\Shared\Transfer\CompanyTransfer;
use Orm\Zed\Company\Persistence\SpyCompany;

class CompanyMapper implements CompanyMapperInterface
{
    /**
     * @param \Orm\Zed\Company\Persistence\SpyCompany $spyCompany
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function mapEntityToTransfer(
        SpyCompany $spyCompany,
        CompanyTransfer $companyTransfer
    ): CompanyTransfer {
        return $companyTransfer->fromArray(
            $spyCompany->toArray(),
            true,
        );
    }
}
