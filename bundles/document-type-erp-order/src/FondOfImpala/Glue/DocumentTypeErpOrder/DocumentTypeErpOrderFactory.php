<?php

namespace FondOfImpala\Glue\DocumentTypeErpOrder;

use FondOfImpala\Glue\DocumentTypeErpOrder\Model\Mapper\RequestMapper;
use FondOfImpala\Glue\DocumentTypeErpOrder\Model\Mapper\RequestMapperInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class DocumentTypeErpOrderFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\DocumentTypeErpOrder\Model\Mapper\RequestMapperInterface
     */
    public function createRequestMapper(): RequestMapperInterface
    {
        return new RequestMapper();
    }
}
