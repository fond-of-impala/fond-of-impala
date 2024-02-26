<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityCompanySearchRestApi\Communication\Plugin\CompanySearchRestApi;

use FondOfOryx\Glue\CompanySearchRestApiExtension\Dependency\Plugin\RestCompanySearchResultItemExpanderPluginInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\RestCompanySearchResultItemTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfImpala\Glue\ConditionalAvailabilityCompanySearchRestApi\ConditionalAvailabilityCompanySearchRestApiConfig getConfig()
 */
class AvailabilityChannelFallbackRestCompanySearchResultItemExpanderPlugin extends AbstractPlugin implements RestCompanySearchResultItemExpanderPluginInterface
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
        $channel = $companyTransfer->getAvailabilityChannel();

        if ($channel === null || $channel === '') {
            $channel = $this->getConfig()->getFallbackAvailabilityChannel();
        }

        return $restCompanySearchResultItemTransfer->setAvailabilityChannel($channel);
    }
}
