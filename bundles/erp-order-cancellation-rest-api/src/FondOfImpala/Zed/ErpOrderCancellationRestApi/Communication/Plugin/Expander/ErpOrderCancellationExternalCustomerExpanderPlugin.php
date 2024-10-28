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
class ErpOrderCancellationExternalCustomerExpanderPlugin extends AbstractPlugin implements ErpOrderCancellationExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function expand(ErpOrderCancellationTransfer $erpOrderCancellationTransfer, RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer): ErpOrderCancellationTransfer
    {
        $fkCustomerRequested = $erpOrderCancellationTransfer->getFkCustomerRequested();

        if ($fkCustomerRequested !== null){
            return $erpOrderCancellationTransfer;
        }

        $attributes = $restErpOrderCancellationRequestTransfer->getAttributes();
        $originator = $attributes->getOriginator();

        return $erpOrderCancellationTransfer->setFkCustomerRequested($originator->getIdCustomer());
    }

}
