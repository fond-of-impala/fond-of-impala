<?php

namespace FondOfImpala\Glue\DocumentTypeErpDeliveryNote;

use FondOfImpala\Glue\DocumentTypeErpDeliveryNote\Model\Mapper\RequestMapper;
use FondOfImpala\Glue\DocumentTypeErpDeliveryNote\Model\Mapper\RequestMapperInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class DocumentTypeErpDeliveryNoteFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\DocumentTypeErpDeliveryNote\Model\Mapper\RequestMapperInterface
     */
    public function createRequestMapper(): RequestMapperInterface
    {
        return new RequestMapper();
    }
}
