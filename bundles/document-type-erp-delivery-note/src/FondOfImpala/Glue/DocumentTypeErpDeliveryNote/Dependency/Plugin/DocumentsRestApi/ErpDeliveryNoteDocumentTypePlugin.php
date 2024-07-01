<?php

namespace FondOfImpala\Glue\DocumentTypeErpDeliveryNote\Dependency\Plugin\DocumentsRestApi;

use FondOfImpala\Shared\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteConstants;
use FondOfOryx\Glue\DocumentsRestApi\Dependency\Plugin\DocumentTypePluginInterface;
use Generated\Shared\Transfer\DocumentRestRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfImpala\Client\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteClientInterface getClient()
 * @method \FondOfImpala\Glue\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteFactory getFactory()
 */
class ErpDeliveryNoteDocumentTypePlugin extends AbstractPlugin implements DocumentTypePluginInterface
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return DocumentTypeErpDeliveryNoteConstants::TYPE;
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
