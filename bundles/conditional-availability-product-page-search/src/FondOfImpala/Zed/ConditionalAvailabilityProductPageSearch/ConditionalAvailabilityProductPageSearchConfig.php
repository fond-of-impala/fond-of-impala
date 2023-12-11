<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch;

use Spryker\Zed\Kernel\AbstractBundleConfig;

/**
 * @codeCoverageIgnore
 */
class ConditionalAvailabilityProductPageSearchConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getDuration(): string
    {
        return 'PT1M';
    }
}
