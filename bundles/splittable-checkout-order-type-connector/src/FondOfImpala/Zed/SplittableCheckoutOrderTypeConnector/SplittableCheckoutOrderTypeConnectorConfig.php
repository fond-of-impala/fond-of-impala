<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector;

use FondOfImpala\Shared\SplittableCheckoutOrderTypeConnector\SplittableCheckoutOrderTypeConnectorConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

/**
 * @codeCoverageIgnore
 */
class SplittableCheckoutOrderTypeConnectorConfig extends AbstractBundleConfig
{
    /**
     * @return bool
     */
    public function getAllowEmptyOrderType(): bool
    {
        return $this->get(SplittableCheckoutOrderTypeConnectorConstants::ALLOW_EMPTY_ORDER_TYPE, false);
    }
}
