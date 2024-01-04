<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Orm\Zed\AllowedProductQuantity\Persistence\FoiAllowedProductQuantity;
use Propel\Runtime\Collection\ObjectCollection;

interface AllowedProductQuantityMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\AllowedProductQuantityTransfer $transfer
     *
     * @return \Orm\Zed\AllowedProductQuantity\Persistence\FoiAllowedProductQuantity
     */
    public function mapTransferToEntity(AllowedProductQuantityTransfer $transfer): FoiAllowedProductQuantity;

    /**
     * @param \Orm\Zed\AllowedProductQuantity\Persistence\FoiAllowedProductQuantity $entity
     *
     * @return \Generated\Shared\Transfer\AllowedProductQuantityTransfer
     */
    public function mapEntityToTransfer(FoiAllowedProductQuantity $entity): AllowedProductQuantityTransfer;

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $entityCollection
     *
     * @return array<string, \Generated\Shared\Transfer\AllowedProductQuantityTransfer>
     */
    public function mapEntityCollectionToGroupedTransfers(ObjectCollection $entityCollection): array;
}
