<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Communication\Plugin\ConditionalAvailabilityExtension;

use FondOfImpala\Zed\ConditionalAvailabilityExtension\Dependency\Plugin\ConditionalAvailabilityPostSavePluginInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface getFacade()
 */
class ConditionalAvailabilityPeriodsPersisterPlugin extends AbstractPlugin implements ConditionalAvailabilityPostSavePluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function postSave(
        ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
    ): ConditionalAvailabilityResponseTransfer {
        if (
            $conditionalAvailabilityResponseTransfer->getIsSuccessful() === false
            || $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer() === null
        ) {
            return $conditionalAvailabilityResponseTransfer;
        }

        $conditionalAvailabilityTransfer = $this->getFacade()->persistConditionalAvailabilityPeriods(
            $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer(),
        );

        return $conditionalAvailabilityResponseTransfer->setConditionalAvailabilityTransfer(
            $conditionalAvailabilityTransfer,
        );
    }
}
