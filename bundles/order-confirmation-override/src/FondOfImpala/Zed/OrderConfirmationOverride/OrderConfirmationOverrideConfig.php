<?php

namespace FondOfImpala\Zed\OrderConfirmationOverride;

use FondOfImpala\Shared\OrderConfirmationOverride\OrderConfirmationOverrideConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

/**
 * @codeCoverageIgnore
 */
class OrderConfirmationOverrideConfig extends AbstractBundleConfig
{
    /**
     * @return array
     */
    public function getProtectedCompanyTypeIds(): array
    {
        return $this->get(OrderConfirmationOverrideConstants::PROTECTED_COMPANY_TYPE_IDS, []);
    }
}
