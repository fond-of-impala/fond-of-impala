<?php

namespace FondOfImpala\Zed\DocumentTypeErpOrder\Business;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\DocumentTypeErpOrder\Business\DocumentTypeErpOrderBusinessFactory getFactory()
 */
class DocumentTypeErpOrderFacade extends AbstractFacade implements DocumentTypeErpOrderFacadeInterface
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
