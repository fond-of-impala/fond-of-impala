<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Business\Model;

use FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceProductFacadeInterface;
use FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListEntityManagerInterface;
use FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListRepositoryInterface;
use Generated\Shared\Transfer\FoiPriceProductPriceListEntityTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;

class PriceListPriceWriter implements PriceListPriceWriterInterface
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceProductFacadeInterface
     */
    protected $priceProductFacade;

    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListRepositoryInterface
     */
    protected $repository;

    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param \FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceProductFacadeInterface $priceProductFacade
     * @param \FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListRepositoryInterface $repository
     * @param \FondOfImpala\Zed\PriceProductPriceList\Persistence\PriceProductPriceListEntityManagerInterface $entityManager
     */
    public function __construct(
        PriceProductPriceListToPriceProductFacadeInterface $priceProductFacade,
        PriceProductPriceListRepositoryInterface $repository,
        PriceProductPriceListEntityManagerInterface $entityManager
    ) {
        $this->priceProductFacade = $priceProductFacade;
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer
     */
    public function persist(PriceProductTransfer $priceProductTransfer): PriceProductTransfer
    {
        $priceProductTransfer
            ->requireMoneyValue()
            ->requirePriceDimension();

        $priceDimensionTransfer = $priceProductTransfer->getPriceDimension();
        $priceDimensionTransfer->requireIdPriceList();

        if (!$priceProductTransfer->getIdPriceProduct()) {
            $priceProductTransfer = $this->priceProductFacade->persistPriceProductStore($priceProductTransfer);
        }

        $priceProductPriceListEntityTransfer = $this->getPriceProductPriceListEntityTransfer($priceProductTransfer);

        $this->entityManager->persistEntity($priceProductPriceListEntityTransfer);

        return $priceProductTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\FoiPriceProductPriceListEntityTransfer
     */
    protected function getPriceProductPriceListEntityTransfer(PriceProductTransfer $priceProductTransfer): FoiPriceProductPriceListEntityTransfer
    {
        $idPriceProductMerchantRelationship = $this->repository
            ->findIdByPriceProductTransfer($priceProductTransfer);

        $priceProductMerchantRelationshipEntityTransfer = (new FoiPriceProductPriceListEntityTransfer())
            ->setIdPriceProductPriceList($idPriceProductMerchantRelationship)
            ->setFkPriceList($priceProductTransfer->getPriceDimension()->getIdPriceList())
            ->setFkPriceProductStore((string)$priceProductTransfer->getMoneyValue()->getIdEntity());

        if ($priceProductTransfer->getIdProduct()) {
            $priceProductMerchantRelationshipEntityTransfer->setFkProduct($priceProductTransfer->getIdProduct());

            return $priceProductMerchantRelationshipEntityTransfer;
        }

        $priceProductMerchantRelationshipEntityTransfer->setFkProductAbstract($priceProductTransfer->getIdProductAbstract());

        return $priceProductMerchantRelationshipEntityTransfer;
    }

    /**
     * @param int $idPriceProductStore
     *
     * @return void
     */
    public function deleteByIdPriceProductStore(int $idPriceProductStore): void
    {
        $this->entityManager->deleteByIdPriceProductStore($idPriceProductStore);
    }
}
