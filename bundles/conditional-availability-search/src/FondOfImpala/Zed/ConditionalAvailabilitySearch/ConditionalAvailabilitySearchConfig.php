<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class ConditionalAvailabilitySearchConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @return string|null
     */
    public function getEventQueueName(): ?string
    {
        return null;
    }
}
