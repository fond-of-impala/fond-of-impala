<?php

namespace FondOfImpala\Glue\ConditionAvailabilityCompanySearchRestApi\Communication\Plugin\CompanySearchRestApi;

use FondOfOryx\Glue\CompanySearchRestApiExtension\Dependency\Plugin\RestCompanySearchResultItemExpanderPluginInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\RestCompanySearchResultItemTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfImpala\Glue\ConditionAvailabilityCompanySearchRestApi\ConditionAvailabilityCompanySearchRestApiConfig getConfig()
 */
class AvailabilityChannelFallbackRestCompanySearchResultItemExpanderPlugin extends AbstractPlugin implements RestCompanySearchResultItemExpanderPluginInterface
{
    public function expand(RestCompanySearchResultItemTransfer $restCompanySearchResultItemTransfer, CompanyTransfer $companyTransfer): RestCompanySearchResultItemTransfer
    {
        $channel = $companyTransfer->getAvailabilityChannel();

        if ($channel === null || $channel === ''){
            $channel = $this->getConfig()->getFallbackAvailabilityChannel();
        }

        return $restCompanySearchResultItemTransfer->setAvailabilityChannel($channel);
    }

}
