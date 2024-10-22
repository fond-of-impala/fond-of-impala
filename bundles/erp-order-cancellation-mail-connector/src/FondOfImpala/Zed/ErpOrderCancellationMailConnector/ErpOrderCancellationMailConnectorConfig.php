<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector;

use FondOfImpala\Shared\ErpOrderCancellationMailConnector\ErpOrderCancellationMailConnectorConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class ErpOrderCancellationMailConnectorConfig extends AbstractBundleConfig
{
    /**
     * @return array
     */
    public function getRolesToNotify(): array
    {
        return $this->get(ErpOrderCancellationMailConnectorConstants::ROLES_TO_NOTIFY, []);
    }
}
