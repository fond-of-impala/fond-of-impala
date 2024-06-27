<?php

namespace FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Persistence;


use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Generated\Shared\Transfer\ErpDeliveryNoteTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

interface DocumentTypeErpDeliveryNoteRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     * @return \Generated\Shared\Transfer\ErpDeliveryNoteTransfer|null
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getErpDeliveryNoteWithPermissionCheck(DocumentRequestTransfer $documentRequestTransfer): ?ErpDeliveryNoteTransfer;
}
