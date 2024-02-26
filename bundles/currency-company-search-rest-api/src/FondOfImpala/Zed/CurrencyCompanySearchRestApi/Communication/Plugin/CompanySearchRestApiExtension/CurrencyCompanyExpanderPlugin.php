<?php

namespace FondOfImpala\Zed\CurrencyCompanySearchRestApi\Communication\Plugin\CompanySearchRestApiExtension;

use FondOfOryx\Zed\CompanySearchRestApiExtension\Dependency\Plugin\CompanyExpanderPluginInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Throwable;

/**
 * @method \FondOfImpala\Zed\CurrencyCompanySearchRestApi\Communication\CurrencyCompanySearchRestApiCommunicationFactory getFactory()
 */
class CurrencyCompanyExpanderPlugin extends AbstractPlugin implements CompanyExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function expand(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        $idCurrency = $companyTransfer->getFkCurrency();

        if ($idCurrency === null) {
            return $companyTransfer;
        }

        try {
            $currencyTransfer = $this->getFactory()
                ->getCurrencyFacade()
                ->getByIdCurrency($idCurrency);

            return $companyTransfer->setCurrency($currencyTransfer);
        } catch (Throwable) {
            return $companyTransfer;
        }
    }
}
