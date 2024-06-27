<?php

namespace FondOfImpala\Zed\DocumentTypeErpOrder\Persistence;


use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Generated\Shared\Transfer\ErpOrderTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

interface DocumentTypeErpOrderRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     * @return \Generated\Shared\Transfer\ErpOrderTransfer|null
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getErpOrder(DocumentRequestTransfer $documentRequestTransfer): ?ErpOrderTransfer;

    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     * @return \Generated\Shared\Transfer\ErpOrderTransfer|null
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getErpOrderWithPermissionCheck(DocumentRequestTransfer $documentRequestTransfer): ?ErpOrderTransfer;
}
