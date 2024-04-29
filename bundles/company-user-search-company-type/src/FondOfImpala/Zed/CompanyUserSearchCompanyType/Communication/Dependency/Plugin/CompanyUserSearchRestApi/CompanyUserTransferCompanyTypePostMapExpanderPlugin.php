<?php

namespace FondOfImpala\Zed\CompanyUserSearchCompanyType\Communication\Dependency\Plugin\CompanyUserSearchRestApi;

use FondOfOryx\Zed\CompanyUserSearchRestApiExtension\Dependency\Plugin\CompanyUserTransferPostMapExpanderPluginInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUser;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyUserSearchCompanyType\Persistence\CompanyUserSearchCompanyTypeRepositoryInterface getRepository()
 */
class CompanyUserTransferCompanyTypePostMapExpanderPlugin extends AbstractPlugin implements CompanyUserTransferPostMapExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Orm\Zed\CompanyUser\Persistence\SpyCompanyUser $spyCompanyUser
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function expand(CompanyUserTransfer $companyUserTransfer, SpyCompanyUser $spyCompanyUser): CompanyUserTransfer
    {
        $companyTransfer = $this->getRepository()->getCompanyByCompanyUserEntity($spyCompanyUser);
        $companyTypeTransfer = $companyTransfer->getCompanyType();
        if ($companyTypeTransfer !== null) {
            $companyUserTransfer->setCompanyTypeName($companyTypeTransfer->getName());
        }

        return $companyUserTransfer->setCompany($companyTransfer);
    }
}
