<?php

namespace FondOfImpala\Glue\DocumentTypeErpInvoice\Dependency\Plugin\DocumentsRestApi;

use FondOfImpala\Shared\DocumentTypeErpInvoice\DocumentTypeErpInvoiceConstants;
use FondOfOryx\Glue\DocumentsRestApi\Dependency\Plugin\DocumentTypePluginInterface;
use Generated\Shared\Transfer\DocumentRestRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfImpala\Client\DocumentTypeErpInvoice\DocumentTypeErpInvoiceClientInterface getClient()
 * @method \FondOfImpala\Glue\DocumentTypeErpInvoice\DocumentTypeErpInvoiceFactory getFactory()
 */
class ErpInvoiceDocumentTypePlugin extends AbstractPlugin implements DocumentTypePluginInterface
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return DocumentTypeErpInvoiceConstants::TYPE;
    }

    /**
     * @param \Generated\Shared\Transfer\DocumentRestRequestTransfer $documentRestRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EasyApiFilterTransfer
     */
    public function createEasyApiFilter(DocumentRestRequestTransfer $documentRestRequestTransfer): EasyApiFilterTransfer
    {
        return $this->getClient()->getFilterTransfer($this->getFactory()->createRequestMapper()->fromRestRequest($documentRestRequestTransfer));
    }
}
