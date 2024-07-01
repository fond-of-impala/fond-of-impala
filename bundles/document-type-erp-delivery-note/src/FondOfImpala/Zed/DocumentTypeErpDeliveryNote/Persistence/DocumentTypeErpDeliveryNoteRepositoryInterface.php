<?php

namespace FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Persistence;

use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\ErpDeliveryNoteTransfer;

interface DocumentTypeErpDeliveryNoteRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\ErpDeliveryNoteTransfer|null
     */
    public function getErpDeliveryNoteWithPermissionCheck(DocumentRequestTransfer $documentRequestTransfer): ?ErpDeliveryNoteTransfer;
}
