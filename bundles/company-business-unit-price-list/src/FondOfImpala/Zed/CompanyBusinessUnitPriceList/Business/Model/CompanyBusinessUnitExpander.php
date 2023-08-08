<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\Model;

use FondOfImpala\Zed\CompanyBusinessUnitPriceList\Dependency\Facade\CompanyBusinessUnitPriceListToPriceListFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\PriceListTransfer;

class CompanyBusinessUnitExpander implements CompanyBusinessUnitExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitPriceList\Dependency\Facade\CompanyBusinessUnitPriceListToPriceListFacadeInterface
     */
    protected $priceListFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyBusinessUnitPriceList\Dependency\Facade\CompanyBusinessUnitPriceListToPriceListFacadeInterface $priceListFacade
     */
    public function __construct(CompanyBusinessUnitPriceListToPriceListFacadeInterface $priceListFacade)
    {
        $this->priceListFacade = $priceListFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function expand(CompanyBusinessUnitTransfer $companyBusinessUnitTransfer): CompanyBusinessUnitTransfer
    {
        $companyTransfer = $companyBusinessUnitTransfer->getCompany();

        if ($companyTransfer === null || $companyTransfer->getFkPriceList() === null) {
            return $companyBusinessUnitTransfer;
        }

        $priceListTransfer = (new PriceListTransfer())->setIdPriceList($companyTransfer->getFkPriceList());

        $companyTransfer->setPriceList($this->priceListFacade->findPriceListById($priceListTransfer));

        return $companyBusinessUnitTransfer;
    }
}
