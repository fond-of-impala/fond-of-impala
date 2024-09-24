<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader;

use FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationRepositoryInterface;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

class ErpOrderCancellationReader implements ReaderInterface
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
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer|null
     */
    public function findErpOrderCancellationByIdErpOrderCancellation(int $idErpOrderCancellation): ?ErpOrderCancellationTransfer
    {
        return $this->repository->findErpOrderCancellationByIdErpOrderCancellation($idErpOrderCancellation);
    }
}
