<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Persistence\Expander;

use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;

interface CompanyUserQueryExpanderInterface
{
    /**
     * @param \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery $companyUserQuery
     *
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     */
    public function expand(SpyCompanyUserQuery $companyUserQuery): SpyCompanyUserQuery;
}
