<?php

namespace FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Business;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Business\DocumentTypeErpDeliveryNoteBusinessFactory getFactory()
 */
class DocumentTypeErpDeliveryNoteFacade extends AbstractFacade implements DocumentTypeErpDeliveryNoteFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     * @return \Generated\Shared\Transfer\EasyApiFilterTransfer
     */
    public function getFilter(DocumentRequestTransfer $documentRequestTransfer): EasyApiFilterTransfer
    {
        return $this->getFactory()->createEasyApiFilterBuilder()->build($documentRequestTransfer);
    }
}
