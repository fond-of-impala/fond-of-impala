<?php

namespace FondOfImpala\Zed\CustomerPriceList\Business\Model;

use FondOfImpala\Zed\CustomerPriceList\Persistence\CustomerPriceListRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\PriceListCollectionTransfer;

class CustomerPriceListReader implements CustomerPriceListReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\CustomerPriceList\Persistence\CustomerPriceListRepositoryInterface
     */
    protected $customerPriceListRepository;

    /**
     * @param \FondOfImpala\Zed\CustomerPriceList\Persistence\CustomerPriceListRepositoryInterface $customerPriceListRepository
     */
    public function __construct(
        CustomerPriceListRepositoryInterface $customerPriceListRepository
    ) {
        $this->customerPriceListRepository = $customerPriceListRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    public function getPriceListCollectionByIdCustomer(CustomerTransfer $customerTransfer): PriceListCollectionTransfer
    {
        $customerTransfer->requireIdCustomer();

        $idCustomer = $customerTransfer->getIdCustomer();

        return $this->customerPriceListRepository->getPriceListCollectionByIdCustomer($idCustomer);
    }
}
