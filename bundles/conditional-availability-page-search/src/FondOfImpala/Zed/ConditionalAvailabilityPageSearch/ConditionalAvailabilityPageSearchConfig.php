<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch;

use FondOfImpala\Shared\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConstants;
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

    /**
     * @return int
     */
    public function getEventChunkSize(): int
    {
        return $this->get(
            ConditionalAvailabilityPageSearchConstants::EVENT_CHUNK_SIZE,
            ConditionalAvailabilityPageSearchConstants::EVENT_CHUNK_SIZE_DEFAULT,
        );
    }
}
