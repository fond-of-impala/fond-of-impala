<?php

namespace FondOfImpala\Zed\DocumentTypeErpOrder\Business;

use FondOfImpala\Zed\DocumentTypeErpOrder\Business\Builder\EasyApiFilterBuilder;
use FondOfImpala\Zed\DocumentTypeErpOrder\Business\Builder\EasyApiFilterBuilderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\DocumentTypeErpOrder\DocumentTypeErpOrderConfig getConfig()
 * @method \FondOfImpala\Zed\DocumentTypeErpOrder\Persistence\DocumentTypeErpOrderRepositoryInterface getRepository()
 */
class DocumentTypeErpOrderBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\DocumentTypeErpOrder\Business\Builder\EasyApiFilterBuilderInterface
     */
    public function createEasyApiFilterBuilder(): EasyApiFilterBuilderInterface
    {
        return new EasyApiFilterBuilder(
            $this->getRepository(),
            $this->getConfig(),
        );
    }
}
