<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride;

use FondOfImpala\Shared\OrderConfirmationRecipientsOverride\OrderConfirmationRecipientsOverrideConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

/**
 * @codeCoverageIgnore
 */
class OrderConfirmationRecipientsOverrideConfig extends AbstractBundleConfig
{
    /**
     * @return array
     */
    public function getProtectedCompanyTypeIds(): array
    {
        return $this->get(OrderConfirmationRecipientsOverrideConstants::PROTECTED_COMPANY_TYPE_IDS, []);
    }
}
