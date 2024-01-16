<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityCartConnector\Plugin\CompanyUserCartsRestApi;

use FondOfImpala\Glue\CompanyUserCartsRestApi\Dependency\Plugin\RestCartItemExpanderPluginInterface;
use Generated\Shared\Transfer\RestCartItemTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfImpala\Glue\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorFactory getFactory()
 */
class ConditionalAvailabilityCartConnectorGroupKeyRestCartItemExpanderPlugin extends AbstractPlugin implements RestCartItemExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCartItemTransfer $restCartItemTransfer
     *
     * @return \Generated\Shared\Transfer\RestCartItemTransfer
     */
    public function expand(RestCartItemTransfer $restCartItemTransfer): RestCartItemTransfer
    {
        $groupKey = $this->getFactory()->getService()->buildRestCartItemGroupKey($restCartItemTransfer);

        $restCartItemTransfer->setGroupKey($groupKey);

        return $restCartItemTransfer;
    }
}
