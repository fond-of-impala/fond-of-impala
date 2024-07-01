<?php

namespace FondOfImpala\Glue\DocumentTypeErpOrder\Dependency\Plugin\DocumentsRestApi;

use FondOfImpala\Shared\DocumentTypeErpOrder\DocumentTypeErpOrderConstants;
use FondOfOryx\Glue\DocumentsRestApi\Dependency\Plugin\DocumentTypePluginInterface;
use Generated\Shared\Transfer\DocumentRestRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfImpala\Client\DocumentTypeErpOrder\DocumentTypeErpOrderClientInterface getClient()
 * @method \FondOfImpala\Glue\DocumentTypeErpOrder\DocumentTypeErpOrderFactory getFactory()
 */
class ErpOrderDocumentTypePlugin extends AbstractPlugin implements DocumentTypePluginInterface
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return DocumentTypeErpOrderConstants::TYPE;
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
