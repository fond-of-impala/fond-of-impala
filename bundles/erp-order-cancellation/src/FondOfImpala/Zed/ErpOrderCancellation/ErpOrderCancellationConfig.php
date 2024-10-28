<?php

namespace FondOfImpala\Zed\ErpOrderCancellation;

use FondOfImpala\Shared\ErpOrderCancellation\ErpOrderCancellationConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class ErpOrderCancellationConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getPrefixToReplace(): string
    {
        return $this->get(ErpOrderCancellationConstants::PREFIX_TO_REPLACE, ErpOrderCancellationConstants::DEFAULT_PREFIX_TO_REPLACE);
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->get(ErpOrderCancellationConstants::PREFIX, ErpOrderCancellationConstants::DEFAULT_PREFIX);
    }

    /**
     * @return array<int>
     */
    public function getReasonForCancellation(): array
    {
        return $this->get(ErpOrderCancellationConstants::REASON_FOR_CANCELLATION_MAPPING, []);
    }
}
