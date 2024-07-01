<?php

namespace FondOfImpala\Glue\DocumentTypeErpDeliveryNote\Model\Mapper;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\DocumentRestRequestTransfer;

interface RequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRestRequestTransfer $restRequestTransfer
     *
     * @return \Generated\Shared\Transfer\DocumentRequestTransfer
     */
    public function fromRestRequest(DocumentRestRequestTransfer $restRequestTransfer): DocumentRequestTransfer;
}
