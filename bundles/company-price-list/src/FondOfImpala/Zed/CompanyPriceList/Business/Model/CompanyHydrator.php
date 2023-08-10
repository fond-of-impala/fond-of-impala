<?php

namespace FondOfImpala\Zed\CompanyPriceList\Business\Model;

use FondOfImpala\Zed\CompanyPriceList\Dependency\Facade\CompanyPriceListToPriceListFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\PriceListTransfer;

class CompanyHydrator implements CompanyHydratorInterface
{
    protected CompanyPriceListToPriceListFacadeInterface $priceListFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyPriceList\Dependency\Facade\CompanyPriceListToPriceListFacadeInterface $priceListFacade
     */
    public function __construct(CompanyPriceListToPriceListFacadeInterface $priceListFacade)
    {
        $this->priceListFacade = $priceListFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function hydrate(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        $priceListId = $companyTransfer->getFkPriceList();

        if ($priceListId === null) {
            return $companyTransfer;
        }

        $priceListTransfer = (new PriceListTransfer())->setIdPriceList($priceListId);

        $priceListTransfer = $this->priceListFacade->findPriceListById($priceListTransfer);

        return $companyTransfer->setPriceList($priceListTransfer);
    }
}
