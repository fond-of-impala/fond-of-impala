<?php

namespace FondOfImpala\Zed\DocumentTypeErpInvoice\Business;

use FondOfImpala\Zed\DocumentTypeErpInvoice\Business\Builder\EasyApiFilterBuilder;
use FondOfImpala\Zed\DocumentTypeErpInvoice\Business\Builder\EasyApiFilterBuilderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\DocumentTypeErpInvoice\DocumentTypeErpInvoiceConfig getConfig()
 * @method \FondOfImpala\Zed\DocumentTypeErpInvoice\Persistence\DocumentTypeErpInvoiceRepositoryInterface getRepository()
 */
class DocumentTypeErpInvoiceBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\DocumentTypeErpInvoice\Business\Builder\EasyApiFilterBuilderInterface
     */
    public function createEasyApiFilterBuilder(): EasyApiFilterBuilderInterface
    {
        return new EasyApiFilterBuilder(
            $this->getRepository(),
            $this->getConfig(),
        );
    }
}
