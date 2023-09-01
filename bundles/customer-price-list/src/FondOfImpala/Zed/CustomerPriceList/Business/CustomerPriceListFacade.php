<?php

namespace FondOfImpala\Zed\CustomerPriceList\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\PriceListCollectionTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CustomerPriceList\Persistence\CustomerPriceListRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\CustomerPriceList\Business\CustomerPriceListBusinessFactory getFactory()
 */
class CustomerPriceListFacade extends AbstractFacade implements CustomerPriceListFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function expandCustomer(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        return $this->getFactory()->createCustomerExpander()->expand($customerTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    public function getPriceListCollectionByIdCustomer(CustomerTransfer $customerTransfer): PriceListCollectionTransfer
    {
        return $this->getFactory()->createCustomerPriceListReader()->getPriceListCollectionByIdCustomer($customerTransfer);
    }
}
