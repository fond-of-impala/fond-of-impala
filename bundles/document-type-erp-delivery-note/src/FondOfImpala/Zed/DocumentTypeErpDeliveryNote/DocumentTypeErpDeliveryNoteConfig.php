<?php

namespace FondOfImpala\Zed\DocumentTypeErpDeliveryNote;

use FondOfImpala\Shared\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class DocumentTypeErpDeliveryNoteConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getEasyApiStore(): string
    {
        return $this->get(DocumentTypeErpDeliveryNoteConstants::STORE_NAME);
    }
}
