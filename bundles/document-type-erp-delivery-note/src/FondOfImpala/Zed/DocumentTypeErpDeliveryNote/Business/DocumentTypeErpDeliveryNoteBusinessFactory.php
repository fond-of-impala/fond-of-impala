<?php

namespace FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Business;

use FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Business\Builder\EasyApiFilterBuilder;
use FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Business\Builder\EasyApiFilterBuilderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteConfig getConfig()
 * @method \FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Persistence\DocumentTypeErpDeliveryNoteRepositoryInterface getRepository()
 */
class DocumentTypeErpDeliveryNoteBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Business\Builder\EasyApiFilterBuilderInterface
     */
    public function createEasyApiFilterBuilder(): EasyApiFilterBuilderInterface
    {
        return new EasyApiFilterBuilder(
            $this->getRepository(),
            $this->getConfig()
        );
    }
}
