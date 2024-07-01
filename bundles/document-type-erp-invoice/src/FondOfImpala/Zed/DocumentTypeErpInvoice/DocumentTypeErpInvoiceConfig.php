<?php

namespace FondOfImpala\Zed\DocumentTypeErpInvoice;

use FondOfImpala\Shared\DocumentTypeErpInvoice\DocumentTypeErpInvoiceConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class DocumentTypeErpInvoiceConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getEasyApiStore(): string
    {
        return $this->get(DocumentTypeErpInvoiceConstants::STORE_NAME);
    }
}
