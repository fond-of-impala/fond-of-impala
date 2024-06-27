<?php

namespace FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Business\Builder;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;

interface EasyApiFilterBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     * @return \Generated\Shared\Transfer\EasyApiFilterTransfer
     */
    public function build(DocumentRequestTransfer $documentRequestTransfer): EasyApiFilterTransfer;
}
