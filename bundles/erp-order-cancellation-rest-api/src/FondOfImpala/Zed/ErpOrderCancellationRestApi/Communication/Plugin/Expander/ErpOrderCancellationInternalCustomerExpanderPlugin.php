<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\Expander;

use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationExpanderPluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiConfig getConfig()
 */
class ErpOrderCancellationInternalCustomerExpanderPlugin extends AbstractPlugin implements ErpOrderCancellationExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function expand(
        ErpOrderCancellationTransfer $erpOrderCancellationTransfer,
        RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
    ): ErpOrderCancellationTransfer {
        if (!$this->isInternalState($erpOrderCancellationTransfer)) {
            return $erpOrderCancellationTransfer->setFkCustomerInternal(null);
        }
        $fkCustomerInternal = $erpOrderCancellationTransfer->getFkCustomerInternal();

        if ($fkCustomerInternal !== null && $this->getRepository()->isInternalCustomer($fkCustomerInternal, $this->getConfig()->getInternalCompanyTypeIds())) {
            return $erpOrderCancellationTransfer->setFkCustomerInternal(null);
        }

        if ($fkCustomerInternal !== null) {
            return $erpOrderCancellationTransfer;
        }

        $attributes = $restErpOrderCancellationRequestTransfer->getAttributes();
        $originator = $attributes->getOriginator();

        if (!$this->getRepository()->isInternalCustomer($originator->getIdCustomer(), $this->getConfig()->getInternalCompanyTypeIds())) {
            return $erpOrderCancellationTransfer->setFkCustomerInternal(null);
        }

        return $erpOrderCancellationTransfer->setFkCustomerInternal($originator->getIdCustomer());
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     * @return bool
     */
    protected function isInternalState(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): bool
    {
        return in_array($erpOrderCancellationTransfer->getState(), $this->getConfig()->getInternalStates(), true);
    }

}
