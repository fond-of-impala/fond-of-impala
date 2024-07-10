<?php

namespace FondOfImpala\Zed\DocumentTypeErpOrder;

use FondOfImpala\Shared\DocumentTypeErpOrder\DocumentTypeErpOrderConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class DocumentTypeErpOrderConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getEasyApiStore(): string
    {
        return $this->get(DocumentTypeErpOrderConstants::STORE_NAME);
    }
}
