<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Persistence\Mapper;

use Generated\Shared\Transfer\CompanyTransfer;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRole;

interface CompanyMapperInterface
{
    /**
     * @param \Orm\Zed\CompanyRole\Persistence\SpyCompanyRole $spyCompanyRole
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function fromSpyCompanyRole(SpyCompanyRole $spyCompanyRole): ?CompanyTransfer;
}
