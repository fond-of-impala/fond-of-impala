<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Communication\Plugin\CompanyUserExtension;

use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserPreDeletePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\CompanyUserReferenceQuoteConnectorFacadeInterface getFacade()
 */
class QuoteCompanyUserPreDeletePlugin extends AbstractPlugin implements CompanyUserPreDeletePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return void
     */
    public function preDelete(CompanyUserTransfer $companyUserTransfer): void
    {
        $this->getFacade()->deleteQuotesByCompanyUser($companyUserTransfer);
    }
}
