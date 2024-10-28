<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Communication\Plugin\PreSave;

use Exception;
use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPreSavePluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ErpOrderCancellation\ErpOrderCancellationConfig getConfig()
 */
class HandleReasonForCancellationErpOrderCancellationPreSavePlugin extends AbstractPlugin implements ErpOrderCancellationPreSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function preSave(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        $reasonForCancellation = $erpOrderCancellationTransfer->getReasonForCancellation();

        $this->validateReasonForCancellation($erpOrderCancellationTransfer->getErpOrderReference(), $reasonForCancellation);

        foreach ($erpOrderCancellationTransfer->getCancellationItems() as $cancellationItem) {
            if ($cancellationItem->getReasonForCancellation() === null) {
                $cancellationItem->setReasonForCancellation($erpOrderCancellationTransfer->getReasonForCancellation());

                continue;
            }

            $this->validateReasonForCancellation($erpOrderCancellationTransfer->getErpOrderReference(), $cancellationItem->getReasonForCancellation());
        }

        return $erpOrderCancellationTransfer;
    }

    /**
     * @param string $reference
     * @param int|null $reason
     *
     * @throws \Exception
     *
     * @return void
     */
    public function validateReasonForCancellation(string $reference, ?int $reason): void
    {
        if ($reason === null) {
            throw new Exception(sprintf('Reason for cancellation is required "%s"', $reference));
        }

        if (!in_array($reason, $this->getConfig()->getReasonForCancellation(), true)) {
            throw new Exception(sprintf('Reason for cancellation "%s" for order "%s" is not valid', $reason, $reference));
        }
    }
}
