<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector;

use FondOfImpala\Shared\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class ConditionalAvailabilityCartConnectorConfig extends AbstractBundleConfig
{
    public function getDeliveryTimeThreshold(): ?string
    {
        return $this->get(ConditionalAvailabilityCartConnectorConstants::DELIVERY_TIME_THRESHOLD);
    }
}
