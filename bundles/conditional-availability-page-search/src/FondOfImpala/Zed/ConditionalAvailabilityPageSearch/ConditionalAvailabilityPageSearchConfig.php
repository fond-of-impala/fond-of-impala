<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch;

use Spryker\Zed\Kernel\AbstractBundleConfig;

/**
 * @codeCoverageIgnore
 */
class ConditionalAvailabilityPageSearchConfig extends AbstractBundleConfig
{
    /**
     * @return string|null
     */
    public function getConditionalAvailabilityPeriodSynchronizationPoolName(): ?string
    {
        return null;
    }

    /**
     * @return bool
     */
    public function isSendingToQueue(): bool
    {
        return true;
    }
}
