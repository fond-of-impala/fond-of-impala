<?php

namespace FondOfImpala\Zed\PriceList\Business\Model;

use FondOfImpala\Zed\PriceList\Persistence\PriceListEntityManagerInterface;
use Generated\Shared\Transfer\PriceListTransfer;

class PriceListWriter implements PriceListWriterInterface
{
    protected PriceListEntityManagerInterface $entityManager;

    /**
     * @param \FondOfImpala\Zed\PriceList\Persistence\PriceListEntityManagerInterface $entityManager
     */
    public function __construct(PriceListEntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function persist(PriceListTransfer $priceListTransfer): PriceListTransfer
    {
        return $this->entityManager->persist($priceListTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return void
     */
    public function deleteById(PriceListTransfer $priceListTransfer): void
    {
        $priceListTransfer->requireIdPriceList();

        $this->entityManager->deleteById($priceListTransfer->getIdPriceList());
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return void
     */
    public function deleteByName(PriceListTransfer $priceListTransfer): void
    {
        $priceListTransfer->requireName();

        $this->entityManager->deleteByName($priceListTransfer->getName());
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function create(PriceListTransfer $priceListTransfer): PriceListTransfer
    {
        return $this->entityManager->persist($priceListTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function update(PriceListTransfer $priceListTransfer): PriceListTransfer
    {
        $priceListTransfer->requireIdPriceList();

        return $this->entityManager->persist($priceListTransfer);
    }
}
