<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Persistence\Propel\PriceDimensionQueryExpander;

use Generated\Shared\Transfer\PriceProductCriteriaTransfer;
use Generated\Shared\Transfer\PriceProductDimensionTransfer;
use Generated\Shared\Transfer\QueryCriteriaTransfer;
use Generated\Shared\Transfer\QueryJoinTransfer;
use Orm\Zed\PriceProductPriceList\Persistence\Map\FoiPriceProductPriceListTableMap;
use Propel\Runtime\ActiveQuery\Criteria;

class PriceListPriceQueryExpander implements PriceListPriceQueryExpanderInterface
{
    /**
     * @uses \Orm\Zed\PriceProduct\Persistence\Map\SpyPriceProductStoreTableMap::COL_ID_PRICE_PRODUCT_STORE
     *
     * @var string
     */
    public const COL_ID_PRICE_PRODUCT_STORE = 'spy_price_product_store.id_price_product_store';

    /**
     * @param \Generated\Shared\Transfer\PriceProductCriteriaTransfer $priceProductCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\QueryCriteriaTransfer|null
     */
    public function buildPriceListPriceDimensionQueryCriteria(
        PriceProductCriteriaTransfer $priceProductCriteriaTransfer
    ): ?QueryCriteriaTransfer {
        $idPriceList = null;

        if ($priceProductCriteriaTransfer->getPriceDimension() !== null) {
            $idPriceList = $priceProductCriteriaTransfer->getPriceDimension()->getIdPriceList();
        }

        if ($idPriceList) {
            return $this->createQueryCriteriaTransfer([$idPriceList]);
        }

        $idPriceListIds = $this->findPriceListIds($priceProductCriteriaTransfer);
        if (!$idPriceListIds) {
            return null;
        }

        return $this->createQueryCriteriaTransfer($idPriceListIds);
    }

    /**
     * @return \Generated\Shared\Transfer\QueryCriteriaTransfer
     */
    public function buildUnconditionalMerchantRelationshipPriceDimensionQueryCriteria(): QueryCriteriaTransfer
    {
        return (new QueryCriteriaTransfer())
            ->setWithColumns([
                FoiPriceProductPriceListTableMap::COL_FK_PRICE_LIST => PriceProductDimensionTransfer::ID_PRICE_LIST,
            ])->addJoin(
                (new QueryJoinTransfer())
                    ->setLeft([static::COL_ID_PRICE_PRODUCT_STORE])
                    ->setRight([FoiPriceProductPriceListTableMap::COL_FK_PRICE_PRODUCT_STORE])
                    ->setJoinType(Criteria::LEFT_JOIN),
            );
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductCriteriaTransfer $priceProductCriteriaTransfer
     *
     * @return array
     */
    protected function findPriceListIds(PriceProductCriteriaTransfer $priceProductCriteriaTransfer): array
    {
        if (!$priceProductCriteriaTransfer->getQuote()) {
            return [];
        }

        $companyUserTransfer = $priceProductCriteriaTransfer->getQuote()->getCompanyUser();
        if ($companyUserTransfer === null) {
            return [];
        }

        $companyBusinessUnitTransfer = $companyUserTransfer->getCompanyBusinessUnit();
        if ($companyBusinessUnitTransfer === null) {
            return [];
        }

        $companyTransfer = $companyBusinessUnitTransfer->getCompany();
        if ($companyTransfer === null) {
            return [];
        }

        $fkPriceList = $companyTransfer->getFkPriceList();
        if ($companyTransfer->getFkPriceList() === null) {
            return [];
        }

        return [$fkPriceList];
    }

    /**
     * @param array<int> $priceListIds
     *
     * @return \Generated\Shared\Transfer\QueryCriteriaTransfer
     */
    protected function createQueryCriteriaTransfer(array $priceListIds): QueryCriteriaTransfer
    {
        return (new QueryCriteriaTransfer())
            ->setWithColumns([
                FoiPriceProductPriceListTableMap::COL_FK_PRICE_LIST => PriceProductDimensionTransfer::ID_PRICE_LIST,
            ])->addJoin(
                (new QueryJoinTransfer())
                    ->setRelation('PriceProductPriceList')
                    ->setCondition(FoiPriceProductPriceListTableMap::COL_FK_PRICE_LIST
                        . ' IN (' . implode(',', $priceListIds) . ')')
                    ->setJoinType(Criteria::LEFT_JOIN),
            );
    }
}
