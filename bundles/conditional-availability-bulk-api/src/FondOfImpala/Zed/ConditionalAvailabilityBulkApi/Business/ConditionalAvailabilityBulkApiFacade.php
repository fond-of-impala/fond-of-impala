<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business;

use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\ConditionalAvailabilityBulkApiBusinessFactory getFactory()
 */
class ConditionalAvailabilityBulkApiFacade extends AbstractFacade implements ConditionalAvailabilityBulkApiFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function persistConditionalAvailabilities(ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        return $this->getFactory()->createConditionalAvailabilitiesBulkApi()->persist($apiDataTransfer);
    }
}
