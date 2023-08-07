<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Business\Model;

use FondOfImpala\Shared\PriceProductPriceList\PriceProductPriceListConstants;
use FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceListFacadeInterface;
use Generated\Shared\Transfer\PriceListTransfer;
use Generated\Shared\Transfer\PriceProductDimensionTransfer;

class PriceProductDimensionExpander implements PriceProductDimensionExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceListFacadeInterface
     */
    protected $priceListFacade;

    /**
     * @param \FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceListFacadeInterface $priceListFacade
     */
    public function __construct(PriceProductPriceListToPriceListFacadeInterface $priceListFacade)
    {
        $this->priceListFacade = $priceListFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductDimensionTransfer $priceProductDimensionTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    public function expand(PriceProductDimensionTransfer $priceProductDimensionTransfer): PriceProductDimensionTransfer
    {
        $priceListTransfer = (new PriceListTransfer())
            ->setIdPriceList($priceProductDimensionTransfer->getIdPriceList());

        $priceListTransfer = $this->priceListFacade->findPriceListById($priceListTransfer);

        if ($priceListTransfer === null) {
            return $priceProductDimensionTransfer;
        }

        $priceProductDimensionTransfer->setType(PriceProductPriceListConstants::PRICE_DIMENSION_PRICE_LIST)
            ->setName($priceListTransfer->getName());

        return $priceProductDimensionTransfer;
    }
}
