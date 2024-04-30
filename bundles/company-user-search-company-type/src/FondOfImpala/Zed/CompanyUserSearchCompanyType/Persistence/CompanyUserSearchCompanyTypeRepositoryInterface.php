<?php

namespace FondOfImpala\Zed\CompanyUserSearchCompanyType\Persistence;

use Generated\Shared\Transfer\CompanyTransfer;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUser;

interface CompanyUserSearchCompanyTypeRepositoryInterface
{
    /**
     * @param \Orm\Zed\CompanyUser\Persistence\SpyCompanyUser $spyCompanyUser
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function getCompanyByCompanyUserEntity(SpyCompanyUser $spyCompanyUser): CompanyTransfer;
}
