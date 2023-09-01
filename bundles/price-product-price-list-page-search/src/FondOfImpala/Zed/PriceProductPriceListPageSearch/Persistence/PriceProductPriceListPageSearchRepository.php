<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence;

use Generated\Shared\Transfer\FilterTransfer;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchValueTransfer;
use Orm\Zed\Currency\Persistence\Map\SpyCurrencyTableMap;
use Orm\Zed\PriceList\Persistence\Map\FoiPriceListTableMap;
use Orm\Zed\PriceProduct\Persistence\Map\SpyPriceProductStoreTableMap;
use Orm\Zed\PriceProduct\Persistence\Map\SpyPriceTypeTableMap;
use Orm\Zed\PriceProductPriceList\Persistence\FoiPriceProductPriceListQuery;
use Orm\Zed\PriceProductPriceList\Persistence\Map\FoiPriceProductPriceListTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductTableMap;
use Orm\Zed\Store\Persistence\Map\SpyStoreTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Spryker\Zed\PropelOrm\Business\Model\Formatter\PropelArraySetFormatter;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchPersistenceFactory getFactory()
 */
class PriceProductPriceListPageSearchRepository extends AbstractRepository implements PriceProductPriceListPageSearchRepositoryInterface
{
    /**
     * @param int[] $priceProductPriceListIds
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[]
     */
    public function findPriceProductPriceListByIds(array $priceProductPriceListIds): array
    {
        $foiPriceProductPriceListQuery = $this->queryPriceProductPriceList()
            ->innerJoinProductAbstract()
            ->filterByIdPriceProductPriceList_In($priceProductPriceListIds)
            ->filterByFkProductAbstract(null, Criteria::ISNOTNULL);

        $priceProductPriceLists = $this->withPriceProductAbstractData($foiPriceProductPriceListQuery)
            ->setFormatter(new PropelArraySetFormatter())
            ->find();

        return $this->getFactory()
            ->createPriceProductPriceListPageSearchMapper()
            ->mapDataArrayToTransferArray(
                $priceProductPriceLists,
            );
    }

    /**
     * @param int $idPriceList
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[]
     */
    public function findPriceProductAbstractPriceListByIdPriceList(int $idPriceList): array
    {
        $foiPriceProductPriceListQuery = $this->queryPriceProductPriceList()
            ->innerJoinProductAbstract()
            ->filterByFkPriceList($idPriceList)
            ->filterByFkProductAbstract(null, Criteria::ISNOTNULL)
            ->filterByFkProduct(null, Criteria::ISNULL);

        $priceProductPriceLists = $this->withPriceProductAbstractData($foiPriceProductPriceListQuery)
            ->setFormatter(new PropelArraySetFormatter())
            ->find();

        return $this->getFactory()
            ->createPriceProductPriceListPageSearchMapper()
            ->mapDataArrayToTransferArray(
                $priceProductPriceLists,
            );
    }

    /**
     * @param int $idPriceList
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[]
     */
    public function findPriceProductConcretePriceListByIdPriceList(int $idPriceList): array
    {
        $foiPriceProductPriceListQuery = $this->queryPriceProductPriceList()
            ->innerJoinProduct()
            ->filterByFkPriceList($idPriceList)
            ->filterByFkProductAbstract(null, Criteria::ISNULL)
            ->filterByFkProduct(null, Criteria::ISNOTNULL);

        $priceProductPriceLists = $this->withPriceProductConcreteData($foiPriceProductPriceListQuery)
            ->setFormatter(new PropelArraySetFormatter())
            ->find();

        return $this->getFactory()
            ->createPriceProductPriceListPageSearchMapper()
            ->mapDataArrayToTransferArray(
                $priceProductPriceLists,
            );
    }

    /**
     * @module Store
     * @module Currency
     * @module PriceProduct
     * @module PriceList
     *
     * @return \Orm\Zed\PriceProductPriceList\Persistence\FoiPriceProductPriceListQuery
     */
    protected function queryPriceProductPriceList(): FoiPriceProductPriceListQuery
    {
        return $this->getFactory()
            ->getPropelPriceProductPriceListQuery()
            ->clear()
            ->usePriceProductStoreQuery()
                ->innerJoinStore()
                ->innerJoinCurrency()
                ->usePriceProductQuery()
                    ->innerJoinPriceType()
                ->endUse()
            ->endUse()
            ->innerJoinPriceList();
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $modelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    protected function withPriceProductAbstractData(ModelCriteria $modelCriteria): ModelCriteria
    {
        return $this->withPriceProductData($modelCriteria)
            ->withColumn(SpyProductAbstractTableMap::COL_SKU, PriceProductPriceListPageSearchTransfer::SKU)
            ->withColumn(FoiPriceProductPriceListTableMap::COL_FK_PRODUCT_ABSTRACT, PriceProductPriceListPageSearchTransfer::ID_PRODUCT);
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $modelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    protected function withPriceProductConcreteData(ModelCriteria $modelCriteria): ModelCriteria
    {
        return $this->withPriceProductData($modelCriteria)
            ->withColumn(SpyProductTableMap::COL_SKU, PriceProductPriceListPageSearchTransfer::SKU)
            ->withColumn(FoiPriceProductPriceListTableMap::COL_FK_PRODUCT, PriceProductPriceListPageSearchTransfer::ID_PRODUCT);
    }

    /**
     * @module Store
     * @module Currency
     * @module PriceProduct
     * @module MerchantRelationship
     * @module PriceProductMerchantRelationship
     *
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $modelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    protected function withPriceProductData(ModelCriteria $modelCriteria): ModelCriteria
    {
        return $modelCriteria
            ->withColumn(SpyStoreTableMap::COL_NAME, PriceProductPriceListPageSearchTransfer::STORE_NAME)
            ->withColumn(SpyCurrencyTableMap::COL_CODE, PriceProductPriceListPageSearchValueTransfer::CURRENCY_CODE)
            ->withColumn(FoiPriceProductPriceListTableMap::COL_FK_PRICE_LIST, PriceProductPriceListPageSearchTransfer::ID_PRICE_LIST)
            ->withColumn(FoiPriceListTableMap::COL_NAME, PriceProductPriceListPageSearchTransfer::PRICE_LIST_NAME)
            ->withColumn(SpyPriceTypeTableMap::COL_NAME, PriceProductPriceListPageSearchValueTransfer::PRICE_TYPE)
            ->withColumn(SpyPriceProductStoreTableMap::COL_PRICE_DATA, PriceProductPriceListPageSearchValueTransfer::PRICE_DATA)
            ->withColumn(SpyPriceProductStoreTableMap::COL_GROSS_PRICE, PriceProductPriceListPageSearchValueTransfer::GROSS_PRICE)
            ->withColumn(SpyPriceProductStoreTableMap::COL_NET_PRICE, PriceProductPriceListPageSearchValueTransfer::NET_PRICE);
    }

    /**
     * @param string[] $priceKeys
     *
     * @return \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearch[]
     */
    public function findExistingPriceProductAbstractPriceListEntitiesByPriceKeys(array $priceKeys): array
    {
        return $this->getFactory()
            ->createPriceProductAbstractPriceListPageSearchQuery()
            ->filterByPriceKey_In($priceKeys)
            ->find()
            ->getData();
    }

    /**
     * @param int[] $productAbstractIds
     *
     * @return \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductAbstractPriceListPageSearch[]
     */
    public function findExistingPriceProductAbstractPriceListEntitiesByProductAbstractIds(array $productAbstractIds): array
    {
        return $this->getFactory()
            ->createPriceProductAbstractPriceListPageSearchQuery()
            ->filterByFkProductAbstract_In($productAbstractIds)
            ->find()
            ->getData();
    }

    /**
     * @param int[] $productAbstractIds
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[]
     */
    public function findPriceListProductAbstractPricesDataByProductAbstractIds(array $productAbstractIds): array
    {
        $priceProductPriceListQuery = $this->queryPriceProductPriceList()
            ->innerJoinProductAbstract()
            ->filterByFkProductAbstract_In($productAbstractIds);

        $priceProductPriceLists = $this->withPriceProductAbstractData($priceProductPriceListQuery)
            ->setFormatter(new PropelArraySetFormatter())
            ->find();

        return $this->getFactory()
            ->createPriceProductPriceListPageSearchMapper()
            ->mapDataArrayToTransferArray(
                $priceProductPriceLists,
            );
    }

    /**
     * @param \Generated\Shared\Transfer\FilterTransfer $filterTransfer
     * @param int[] $priceProductConcretePriceListPageSearchIds
     *
     * @return \Generated\Shared\Transfer\FoiPriceProductConcretePriceListPageSearchEntityTransfer[]
     */
    public function findFilteredPriceProductConcretePriceListPageSearchEntities(
        FilterTransfer $filterTransfer,
        array $priceProductConcretePriceListPageSearchIds = []
    ): array {
        $query = $this->getFactory()->createPriceProductConcretePriceListPageSearchQuery();

        if ($priceProductConcretePriceListPageSearchIds) {
            $query->filterByIdPriceProductConcretePriceListPageSearch_In($priceProductConcretePriceListPageSearchIds);
        }

        return $this->buildQueryFromCriteria($query, $filterTransfer)->find();
    }

    /**
     * @param \Generated\Shared\Transfer\FilterTransfer $filterTransfer
     * @param int[] $priceProductAbstractPriceListPageSearchIds
     *
     * @return \Generated\Shared\Transfer\FoiPriceProductAbstractPriceListPageSearchEntityTransfer[]
     */
    public function findFilteredPriceProductAbstractPriceListPageSearchEntities(
        FilterTransfer $filterTransfer,
        array $priceProductAbstractPriceListPageSearchIds = []
    ): array {
        $query = $this->getFactory()->createPriceProductAbstractPriceListPageSearchQuery();

        if ($priceProductAbstractPriceListPageSearchIds) {
            $query->filterByIdPriceProductAbstractPriceListPageSearch_In($priceProductAbstractPriceListPageSearchIds);
        }

        return $this->buildQueryFromCriteria($query, $filterTransfer)->find();
    }

    /**
     * @param int[] $priceProductPriceListIds
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[]
     */
    public function findPriceListProductConcretePricesDataByIds(array $priceProductPriceListIds): array
    {
        $priceProductMerchantRelationshipsQuery = $this->queryPriceProductPriceList()
            ->innerJoinProduct()
            ->filterByIdPriceProductPriceList_In($priceProductPriceListIds)
            ->filterByFkProduct(null, Criteria::ISNOTNULL);

        $priceProductMerchantRelationships = $this->withPriceProductConcreteData($priceProductMerchantRelationshipsQuery)
            ->setFormatter(new PropelArraySetFormatter())
            ->find();

        return $this->getFactory()
            ->createPriceProductPriceListPageSearchMapper()
            ->mapDataArrayToTransferArray(
                $priceProductMerchantRelationships,
            );
    }

    /**
     * @param string[] $priceKeys
     *
     * @return \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearch[]
     */
    public function findExistingPriceProductConcretePriceListEntitiesByPriceKeys(array $priceKeys): array
    {
        return $this->getFactory()
            ->createPriceProductConcretePriceListPageSearchQuery()
            ->filterByPriceKey_In($priceKeys)
            ->find()
            ->getData();
    }

    /**
     * @param int[] $productIds
     *
     * @return \Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer[]
     */
    public function findPriceListProductConcretePricesDataByProductIds(array $productIds): array
    {
        $priceProductPriceListQuery = $this->queryPriceProductPriceList()
            ->innerJoinProduct()
            ->filterByFkProduct_In($productIds);

        $priceProductPriceLists = $this->withPriceProductConcreteData($priceProductPriceListQuery)
            ->setFormatter(new PropelArraySetFormatter())
            ->find();

        return $this->getFactory()
            ->createPriceProductPriceListPageSearchMapper()
            ->mapDataArrayToTransferArray(
                $priceProductPriceLists,
            );
    }

    /**
     * @param int[] $productIds
     *
     * @return \Orm\Zed\PriceProductPriceListPageSearch\Persistence\FoiPriceProductConcretePriceListPageSearch[]
     */
    public function findExistingPriceProductConcretePriceListEntitiesByProductIds(array $productIds): array
    {
        return $this->getFactory()
            ->createPriceProductConcretePriceListPageSearchQuery()
            ->filterByFkProduct_In($productIds)
            ->find()
            ->getData();
    }
}
