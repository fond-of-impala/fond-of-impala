<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence;

use Generated\Shared\Transfer\FilterTransfer;

interface PriceProductPriceListPageSearchRepositoryInterface
{
    /**
     * @param int[] $priceProductPriceListIds
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[]
     */
    public function findPriceProductPriceListByIds(array $priceProductPriceListIds): array;

    /**
     * @param int $idPriceList
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[]
     */
    public function findPriceProductAbstractPriceListByIdPriceList(int $idPriceList): array;

    /**
     * @param int $idPriceList
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[]
     */
    public function findPriceProductConcretePriceListByIdPriceList(int $idPriceList): array;

    /**
     * @param string[] $priceKeys
     *
     * @return \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearch[]
     */
    public function findExistingPriceProductAbstractPriceListEntitiesByPriceKeys(array $priceKeys): array;

    /**
     * @param int[] $productAbstractIds
     *
     * @return \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearch[]
     */
    public function findExistingPriceProductAbstractPriceListEntitiesByProductAbstractIds(
        array $productAbstractIds
    ): array;

    /**
     * @param int[] $productAbstractIds
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[]
     */
    public function findPriceListProductAbstractPricesDataByProductAbstractIds(array $productAbstractIds): array;

    /**
     * @param \Generated\Shared\Transfer\FilterTransfer $filterTransfer
     * @param int[] $priceProductConcretePriceListPageSearchIds
     *
     * @return \Generated\Shared\Transfer\FoiPriceProductConcretePriceListPageSearchEntityTransfer[]
     */
    public function findFilteredPriceProductConcretePriceListPageSearchEntities(
        FilterTransfer $filterTransfer,
        array $priceProductConcretePriceListPageSearchIds = []
    ): array;

    /**
     * @param \Generated\Shared\Transfer\FilterTransfer $filterTransfer
     * @param int[] $priceProductAbstractPriceListPageSearchIds
     *
     * @return \Generated\Shared\Transfer\FoiPriceProductAbstractPriceListPageSearchEntityTransfer[]
     */
    public function findFilteredPriceProductAbstractPriceListPageSearchEntities(
        FilterTransfer $filterTransfer,
        array $priceProductAbstractPriceListPageSearchIds = []
    ): array;

    /**
     * @param int[] $priceProductPriceListIds
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[]
     */
    public function findPriceListProductConcretePricesDataByIds(array $priceProductPriceListIds): array;

    /**
     * @param string[] $priceKeys
     *
     * @return \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearch[]
     */
    public function findExistingPriceProductConcretePriceListEntitiesByPriceKeys(array $priceKeys): array;

    /**
     * @param int[] $productIds
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[]
     */
    public function findPriceListProductConcretePricesDataByProductIds(array $productIds): array;

    /**
     * @param int[] $productIds
     *
     * @return \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearch[]
     */
    public function findExistingPriceProductConcretePriceListEntitiesByProductIds(array $productIds): array;
}
