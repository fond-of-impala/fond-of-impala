<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence;

use Generated\Shared\Transfer\FilterTransfer;

interface PriceProductPriceListPageSearchRepositoryInterface
{
    /**
     * @param array<int> $priceProductPriceListIds
     *
     * @return array<\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer>
     */
    public function findPriceProductPriceListByIds(array $priceProductPriceListIds): array;

    /**
     * @param int $idPriceList
     *
     * @return array<\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer>
     */
    public function findPriceProductAbstractPriceListByIdPriceList(int $idPriceList): array;

    /**
     * @param int $idPriceList
     *
     * @return array<\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer>
     */
    public function findPriceProductConcretePriceListByIdPriceList(int $idPriceList): array;

    /**
     * @param array<string> $priceKeys
     *
     * @return array<\Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearch>
     */
    public function findExistingPriceProductAbstractPriceListEntitiesByPriceKeys(array $priceKeys): array;

    /**
     * @param array<int> $productAbstractIds
     *
     * @return array<\Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearch>
     */
    public function findExistingPriceProductAbstractPriceListEntitiesByProductAbstractIds(
        array $productAbstractIds
    ): array;

    /**
     * @param array<int> $productAbstractIds
     *
     * @return array<\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer>
     */
    public function findPriceListProductAbstractPricesDataByProductAbstractIds(array $productAbstractIds): array;

    /**
     * @param \Generated\Shared\Transfer\FilterTransfer $filterTransfer
     * @param array<int> $priceProductConcretePriceListPageSearchIds
     *
     * @return array<\Generated\Shared\Transfer\FoiPriceProductConcretePriceListPageSearchEntityTransfer>
     */
    public function findFilteredPriceProductConcretePriceListPageSearchEntities(
        FilterTransfer $filterTransfer,
        array $priceProductConcretePriceListPageSearchIds = []
    ): array;

    /**
     * @param \Generated\Shared\Transfer\FilterTransfer $filterTransfer
     * @param array<int> $priceProductAbstractPriceListPageSearchIds
     *
     * @return array<\Generated\Shared\Transfer\FoiPriceProductAbstractPriceListPageSearchEntityTransfer>
     */
    public function findFilteredPriceProductAbstractPriceListPageSearchEntities(
        FilterTransfer $filterTransfer,
        array $priceProductAbstractPriceListPageSearchIds = []
    ): array;

    /**
     * @param array<int> $priceProductPriceListIds
     *
     * @return array<\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer>
     */
    public function findPriceListProductConcretePricesDataByIds(array $priceProductPriceListIds): array;

    /**
     * @param array<string> $priceKeys
     *
     * @return array<\Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearch>
     */
    public function findExistingPriceProductConcretePriceListEntitiesByPriceKeys(array $priceKeys): array;

    /**
     * @param array<int> $productIds
     *
     * @return array<\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer>
     */
    public function findPriceListProductConcretePricesDataByProductIds(array $productIds): array;

    /**
     * @param array<int> $productIds
     *
     * @return array<\Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearch>
     */
    public function findExistingPriceProductConcretePriceListEntitiesByProductIds(array $productIds): array;
}
