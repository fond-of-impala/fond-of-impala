<?php

namespace FondOfImpala\Zed\CustomerPriceList\Persistence;

use Generated\Shared\Transfer\PriceListCollectionTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\CustomerPriceList\Persistence\CustomerPriceListPersistenceFactory getFactory()
 */
class CustomerPriceListRepository extends AbstractRepository implements CustomerPriceListRepositoryInterface
{
    /**
     * @param int $idCustomer
     *
     * @return \Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    public function getPriceListCollectionByIdCustomer(int $idCustomer): PriceListCollectionTransfer
    {
        $query = $this->getFactory()
            ->getPriceListQuery()
            ->clear()
            ->useSpyCompanyQuery()
                ->filterByIsActive(true)
                ->useCompanyUserQuery()
                    ->filterByIsActive(true)
                    ->useCustomerQuery()
                        ->filterByIdCustomer($idCustomer)
                    ->endUse()
                ->endUse()
            ->endUse()
            ->groupByIdPriceList();

        return $this->getFactory()
            ->createPriceListMapper()
            ->mapEntityCollectionToTransfer($query->find());// @phpstan-ignore-line
    }
}
