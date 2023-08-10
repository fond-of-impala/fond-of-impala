<?php

namespace FondOfImpala\Zed\PriceProductPriceListGui\Communication\Form\DataProvider;

use FondOfImpala\Zed\PriceProductPriceListGui\Communication\Form\PriceListPriceDimensionForm;
use FondOfImpala\Zed\PriceProductPriceListGui\Dependency\Facade\PriceProductPriceListGuiToPriceListFacadeInterface;

class PriceListPriceDimensionFormDataProvider
{
    protected PriceProductPriceListGuiToPriceListFacadeInterface $priceListFacade;

    /**
     * @param \FondOfImpala\Zed\PriceProductPriceListGui\Dependency\Facade\PriceProductPriceListGuiToPriceListFacadeInterface $priceListFacade
     */
    public function __construct(PriceProductPriceListGuiToPriceListFacadeInterface $priceListFacade)
    {
        $this->priceListFacade = $priceListFacade;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        $priceListChoices = $this->preparePriceListChoices();

        return [
            PriceListPriceDimensionForm::OPTION_VALUES_PRICE_LIST_CHOICES => $priceListChoices,
        ];
    }

    /**
     * @return array
     */
    protected function preparePriceListChoices(): array
    {
        $choices = [];
        $priceListCollectionTransfer = $this->priceListFacade->getPriceListCollection();

        foreach ($priceListCollectionTransfer->getPriceLists() as $priceListTransfer) {
            $choices[$priceListTransfer->getName()] = $priceListTransfer->getIdPriceList();
        }

        return $choices;
    }
}
