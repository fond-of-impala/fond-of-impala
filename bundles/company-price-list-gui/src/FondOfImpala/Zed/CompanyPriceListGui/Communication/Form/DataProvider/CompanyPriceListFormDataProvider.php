<?php

namespace FondOfImpala\Zed\CompanyPriceListGui\Communication\Form\DataProvider;

use FondOfImpala\Zed\CompanyPriceListGui\Communication\Form\CompanyPriceListForm;
use FondOfImpala\Zed\CompanyPriceListGui\Dependency\Facade\CompanyPriceListGuiToPriceListFacadeInterface;

class CompanyPriceListFormDataProvider
{
    protected CompanyPriceListGuiToPriceListFacadeInterface $priceListFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyPriceListGui\Dependency\Facade\CompanyPriceListGuiToPriceListFacadeInterface $priceListFacade
     */
    public function __construct(CompanyPriceListGuiToPriceListFacadeInterface $priceListFacade)
    {
        $this->priceListFacade = $priceListFacade;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return [
            CompanyPriceListForm::OPTIONS_PRICE_LIST => $this->getPriceListOptions(),
        ];
    }

    /**
     * @return array
     */
    protected function getPriceListOptions(): array
    {
        $priceListOptions = [];
        $priceListCollectionTransfer = $this->priceListFacade->getPriceListCollection();

        foreach ($priceListCollectionTransfer->getPriceLists() as $priceListTransfer) {
            $priceListOptions[$priceListTransfer->getName()] = $priceListTransfer->getIdPriceList();
        }

        return $priceListOptions;
    }
}
