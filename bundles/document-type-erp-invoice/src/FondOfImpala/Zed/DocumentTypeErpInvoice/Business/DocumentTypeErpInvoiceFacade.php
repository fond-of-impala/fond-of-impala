<?php

namespace FondOfImpala\Zed\DocumentTypeErpInvoice\Business;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\DocumentTypeErpInvoice\Business\DocumentTypeErpInvoiceBusinessFactory getFactory()
 */
class DocumentTypeErpInvoiceFacade extends AbstractFacade implements DocumentTypeErpInvoiceFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EasyApiFilterTransfer
     */
    public function getFilter(DocumentRequestTransfer $documentRequestTransfer): EasyApiFilterTransfer
    {
        return $this->getFactory()->createEasyApiFilterBuilder()->build($documentRequestTransfer);
    }
}
