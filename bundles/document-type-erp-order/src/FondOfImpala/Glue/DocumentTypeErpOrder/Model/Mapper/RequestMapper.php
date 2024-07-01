<?php

namespace FondOfImpala\Glue\DocumentTypeErpOrder\Model\Mapper;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\DocumentRestRequestTransfer;

class RequestMapper implements RequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRestRequestTransfer $restRequestTransfer
     *
     * @return \Generated\Shared\Transfer\DocumentRequestTransfer
     */
    public function fromRestRequest(DocumentRestRequestTransfer $restRequestTransfer): DocumentRequestTransfer
    {
        return (new DocumentRequestTransfer())->fromArray($restRequestTransfer->toArray());
    }
}
