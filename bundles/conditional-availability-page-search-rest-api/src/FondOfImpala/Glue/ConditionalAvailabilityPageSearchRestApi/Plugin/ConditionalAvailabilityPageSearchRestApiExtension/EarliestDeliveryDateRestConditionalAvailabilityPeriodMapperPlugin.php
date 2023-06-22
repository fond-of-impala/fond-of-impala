<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Plugin\ConditionalAvailabilityPageSearchRestApiExtension;

use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApiExtension\Dependency\Plugin\RestConditionalAvailabilityPeriodMapperPluginInterface;
use Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\ConditionalAvailabilityPageSearchRestApiFactory getFactory()
 */
class EarliestDeliveryDateRestConditionalAvailabilityPeriodMapperPlugin extends AbstractPlugin implements RestConditionalAvailabilityPeriodMapperPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array $periodData
     * @param \Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransfer
     *
     * @return \Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer
     */
    public function mapPeriodDataToRestConditionalAvailabilityPeriodTransfer(
        array $periodData,
        RestConditionalAvailabilityPeriodTransfer $restConditionalAvailabilityPeriodTransfer
    ): RestConditionalAvailabilityPeriodTransfer {
        $earliestDeliveryDate = $this->getFactory()->createEarliestDeliveryDateGenerator()
            ->generateByRestConditionalAvailabilityPeriodTransfer($restConditionalAvailabilityPeriodTransfer);

        if ($earliestDeliveryDate === null) {
            return $restConditionalAvailabilityPeriodTransfer;
        }

        return $restConditionalAvailabilityPeriodTransfer->setEarliestDeliveryDate(
            $earliestDeliveryDate->format('Y-m-d H:i:s'),
        );
    }
}
