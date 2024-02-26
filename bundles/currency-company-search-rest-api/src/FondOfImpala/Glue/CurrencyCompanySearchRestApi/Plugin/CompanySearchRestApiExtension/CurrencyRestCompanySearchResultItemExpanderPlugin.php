<?php

namespace FondOfImpala\Glue\CurrencyCompanySearchRestApi\Plugin\CompanySearchRestApiExtension;

use FondOfOryx\Glue\CompanySearchRestApiExtension\Dependency\Plugin\RestCompanySearchResultItemExpanderPluginInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\RestCompanySearchResultItemTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class CurrencyRestCompanySearchResultItemExpanderPlugin extends AbstractPlugin implements RestCompanySearchResultItemExpanderPluginInterface
{
 /**
  * @param \Generated\Shared\Transfer\RestCompanySearchResultItemTransfer $restCompanySearchResultItemTransfer
  * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
  *
  * @return \Generated\Shared\Transfer\RestCompanySearchResultItemTransfer
  */
    public function expand(
        RestCompanySearchResultItemTransfer $restCompanySearchResultItemTransfer,
        CompanyTransfer $companyTransfer
    ): RestCompanySearchResultItemTransfer {
        $currencyTransfer = $companyTransfer->getCurrency();

        if ($currencyTransfer === null) {
            return $restCompanySearchResultItemTransfer;
        }

        return $restCompanySearchResultItemTransfer->setCurrencyIsoCode($currencyTransfer->getCode());
    }
}
