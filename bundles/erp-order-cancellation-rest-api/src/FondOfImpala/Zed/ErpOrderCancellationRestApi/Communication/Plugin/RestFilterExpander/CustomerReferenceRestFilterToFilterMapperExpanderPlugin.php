<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\RestFilterExpander;

use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\ErpOrderCancellationRestApiCommunicationFactory getFactory()
 */
class CustomerReferenceRestFilterToFilterMapperExpanderPlugin extends AbstractPlugin implements ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransfer
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer
     */
    public function expand(
        RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransfer,
        ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer
    ): ErpOrderCancellationFilterTransfer {
        if ($restErpOrderCancellationFilterTransfer->getCustomerReference() === null) {
            return $erpOrderCancellationFilterTransfer;
        }
        $customerTransfer = $this->getFactory()
            ->getCustomerFacade()
            ->findByReference($restErpOrderCancellationFilterTransfer->getCustomerReference());

        if (!$customerTransfer) {
            return $erpOrderCancellationFilterTransfer;
        }

        return $erpOrderCancellationFilterTransfer->setFkCustomer($customerTransfer->getIdCustomer());
    }
}
