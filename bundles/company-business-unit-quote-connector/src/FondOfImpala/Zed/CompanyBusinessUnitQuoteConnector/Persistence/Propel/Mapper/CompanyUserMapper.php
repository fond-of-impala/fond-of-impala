<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Orm\Zed\CompanyUser\Persistence\Base\SpyCompanyUser;

class CompanyUserMapper implements CompanyUserMapperInterface
{
    /**
     * @param \Orm\Zed\CompanyUser\Persistence\Base\SpyCompanyUser $spyCompanyUser
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapCompanyUserEntityToCompanyUserTransfer(
        SpyCompanyUser $spyCompanyUser
    ): CompanyUserTransfer {
        return (new CompanyUserTransfer())->fromArray($spyCompanyUser->toArray(), true);
    }
}
