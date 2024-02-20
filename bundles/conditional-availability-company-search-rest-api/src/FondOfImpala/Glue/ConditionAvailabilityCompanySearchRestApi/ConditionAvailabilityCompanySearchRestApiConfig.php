<?php

namespace FondOfImpala\Glue\ConditionAvailabilityCompanySearchRestApi;

use FondOfImpala\Shared\ConditionalAvailabilityCompanySearchRestApi\ConditionalAvailabilityCompanySearchRestApiConstants;
use Spryker\Glue\Kernel\AbstractBundleConfig;

class ConditionAvailabilityCompanySearchRestApiConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getFallbackAvailabilityChannel(): string
    {
        return $this->get(ConditionalAvailabilityCompanySearchRestApiConstants::FALLBACK_AVAILABILITY_CHANNEL, ConditionalAvailabilityCompanySearchRestApiConstants::DEFAULT_FALLBACK_AVAILABILITY_CHANNEL);
    }
}
