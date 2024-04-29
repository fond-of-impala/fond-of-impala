<?php

namespace FondOfImpala\Zed\CompanyUserSearchCompanyType\Persistence;

use Generated\Shared\Transfer\CompanyTransfer;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUser;

interface CompanyUserSearchCompanyTypeRepositoryInterface
{
    /**
     * @param \Orm\Zed\CompanyUser\Persistence\SpyCompanyUser $spyCompanyUser
     * @return \Generated\Shared\Transfer\CompanyTransfer
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getCompanyByCompanyUserEntity(SpyCompanyUser $spyCompanyUser): CompanyTransfer;
}
