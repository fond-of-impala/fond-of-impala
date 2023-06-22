<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestCartItemTransfer;
use Spryker\Service\Kernel\AbstractService;

/**
 * @method \FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceFactory getFactory()
 */
class ConditionalAvailabilityCartConnectorService extends AbstractService implements ConditionalAvailabilityCartConnectorServiceInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return string
     */
    public function buildItemGroupKey(ItemTransfer $itemTransfer): string
    {
        return $this->getFactory()->createItemGroupKeyBuilder()->build($itemTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCartItemTransfer $restCartItemTransfer
     *
     * @return string
     */
    public function buildRestCartItemGroupKey(RestCartItemTransfer $restCartItemTransfer): string
    {
        return $this->getFactory()->createRestCartItemGroupKeyBuilder()->build($restCartItemTransfer);
    }
}
