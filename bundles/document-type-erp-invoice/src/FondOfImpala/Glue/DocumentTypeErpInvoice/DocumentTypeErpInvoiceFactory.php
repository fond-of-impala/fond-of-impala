<?php

namespace FondOfImpala\Glue\DocumentTypeErpInvoice;

use FondOfImpala\Glue\DocumentTypeErpInvoice\Model\Mapper\RequestMapper;
use FondOfImpala\Glue\DocumentTypeErpInvoice\Model\Mapper\RequestMapperInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class DocumentTypeErpInvoiceFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\DocumentTypeErpInvoice\Model\Mapper\RequestMapperInterface
     */
    public function createRequestMapper(): RequestMapperInterface
    {
        return new RequestMapper();
    }
}
