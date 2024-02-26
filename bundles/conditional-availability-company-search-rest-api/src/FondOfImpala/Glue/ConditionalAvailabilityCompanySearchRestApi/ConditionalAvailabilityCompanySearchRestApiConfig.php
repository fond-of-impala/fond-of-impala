<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityCompanySearchRestApi;

use FondOfImpala\Shared\ConditionalAvailabilityCompanySearchRestApi\ConditionalAvailabilityCompanySearchRestApiConstants;
use Spryker\Glue\Kernel\AbstractBundleConfig;

class ConditionalAvailabilityCompanySearchRestApiConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getFallbackAvailabilityChannel(): string
    {
        return $this->get(ConditionalAvailabilityCompanySearchRestApiConstants::FALLBACK_AVAILABILITY_CHANNEL, ConditionalAvailabilityCompanySearchRestApiConstants::DEFAULT_FALLBACK_AVAILABILITY_CHANNEL);
    }
}
