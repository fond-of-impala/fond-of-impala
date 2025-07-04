<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Communication\Plugin\PreSave;

use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPreSavePluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationCriteriaFilterTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\ErpOrderCancellation\ErpOrderCancellationConfig getConfig()
 */
class GenerateCancellationReferenceErpOrderCancellationPreSavePlugin extends AbstractPlugin implements ErpOrderCancellationPreSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function preSave(
        ErpOrderCancellationTransfer $erpOrderCancellationTransfer
    ): ErpOrderCancellationTransfer {
        $erpOrderReference = $erpOrderCancellationTransfer->getErpOrderReference();

        if ($erpOrderReference === null) {
            return $erpOrderCancellationTransfer;
        }

        $erpOrderCancellationReader = $this->getFactory()->createErpOrderCancellationReader();

        $erpOrderCancellationCollection = $erpOrderCancellationReader->getErpOrderCancellationCollection(
            (new ErpOrderCancellationCriteriaFilterTransfer())
                ->setErpOrderReference($erpOrderReference),
        );

        $increment = 1;

        if ($erpOrderCancellationCollection->getCancellations()->count()) {
            /** @var \Generated\Shared\Transfer\ErpOrderCancellationTransfer $lastErpOrderCancellationTransfer */
            $lastErpOrderCancellationTransfer = $erpOrderCancellationCollection->getCancellations()[0];
            $cancellationNumber = $lastErpOrderCancellationTransfer->getCancellationNumber();

            preg_match(
                '/^' . $this->getConfig()->getPrefix() . '\d+-(\d+)$/',
                $cancellationNumber,
                $matches,
            );

            $increment = (int)$matches[1] + 1;
        }

        $erpOrderReference .= '-' . $increment;

        return $erpOrderCancellationTransfer
            ->setCancellationNumber(
                str_replace(
                    $this->getConfig()->getPrefixToReplace(),
                    $this->getConfig()->getPrefix(),
                    $erpOrderReference,
                ),
            );
    }
}
