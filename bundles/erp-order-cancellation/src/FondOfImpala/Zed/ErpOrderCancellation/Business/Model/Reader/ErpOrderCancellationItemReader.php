<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader;

use ArrayObject;
use FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationRepositoryInterface;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;

class ErpOrderCancellationItemReader implements ErpOrderCancellationItemReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationRepositoryInterface
     */
    protected $repository;

    /**
     * @param \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationRepositoryInterface $repository
     */
    public function __construct(ErpOrderCancellationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $idErpOrderCancellation
     * @return \ArrayObject
     */
    public function findErpOrderCancellationItemsByIdErpOrderCancellation(int $idErpOrderCancellation): ArrayObject
    {
        return $this->repository->findErpOrderCancellationItemsByIdErpOrderCancellation($idErpOrderCancellation);
    }

    /**
     * @param int $fkErpOrderCancellation
     * @param string $sku
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer|null
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function findErpOrderCancellationItemByIdErpOrderCancellationAndSku(int $fkErpOrderCancellation, string $sku): ?ErpOrderCancellationItemTransfer
    {
        return $this->repository->findErpOrderCancellationItemByIdErpOrderCancellationAndSku($fkErpOrderCancellation, $sku);
    }
}
