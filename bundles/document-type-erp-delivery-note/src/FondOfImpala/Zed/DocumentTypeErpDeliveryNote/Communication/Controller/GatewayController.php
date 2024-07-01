<?php

namespace FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Communication\Controller;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Business\DocumentTypeErpDeliveryNoteFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EasyApiFilterTransfer
     */
    public function getFilterAction(DocumentRequestTransfer $documentRequestTransfer): EasyApiFilterTransfer
    {
        return $this->getFacade()->getFilter($documentRequestTransfer);
    }
}
