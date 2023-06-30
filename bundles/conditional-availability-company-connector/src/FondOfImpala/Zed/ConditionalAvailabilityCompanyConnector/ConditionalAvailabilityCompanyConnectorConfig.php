<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCompanyConnector;

use FondOfImpala\Shared\ConditionalAvailabilityCompanyConnector\ConditionalAvailabilityCompanyConnectorConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class ConditionalAvailabilityCompanyConnectorConfig extends AbstractBundleConfig
{
    /**
     * @return string|null
     */
    public function getDefaultAvailabilityChannel(): ?string
    {
        return $this->get(ConditionalAvailabilityCompanyConnectorConstants::DEFAULT_AVAILABILITY_CHANNEL, null);
    }
}
