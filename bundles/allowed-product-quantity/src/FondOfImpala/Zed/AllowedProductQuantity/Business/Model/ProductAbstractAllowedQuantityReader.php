<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Business\Model;

use FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityRepositoryInterface;
use Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class ProductAbstractAllowedQuantityReader implements ProductAbstractAllowedQuantityReaderInterface
{
    protected AllowedProductQuantityRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\AllowedProductQuantity\Persistence\AllowedProductQuantityRepositoryInterface $repository
     */
    public function __construct(AllowedProductQuantityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer
     */
    public function findByIdProductAbstract(ProductAbstractTransfer $productAbstractTransfer): AllowedProductQuantityResponseTransfer
    {
        $productAbstractTransfer->requireIdProductAbstract();

        $allowedProductQuantityTransfer = $this->repository
            ->findAllowedProductQuantityByIdProductAbstract($productAbstractTransfer->getIdProductAbstract());

        $allowedProductQuantityResponseTransfer = (new AllowedProductQuantityResponseTransfer())
            ->setIsSuccessful(true)
            ->setAllowedProductQuantityTransfer($allowedProductQuantityTransfer);

        if ($allowedProductQuantityTransfer === null) {
            $allowedProductQuantityResponseTransfer->setIsSuccessful(false);
        }

        return $allowedProductQuantityResponseTransfer;
    }
}
