<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business;

use Codeception\Test\Unit;

class PriceProductPriceListPageSearchFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchFacade
     */
    protected $priceProductPriceListPageSearchFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchBusinessFactory
     */
    protected $priceProductPriceListPageSearchBusinessFactoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductPriceListPageSearchBusinessFactoryMock = $this->getMockBuilder(PriceProductPriceListPageSearchBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchFacade = new PriceProductPriceListPageSearchFacade();
        $this->priceProductPriceListPageSearchFacade->setFactory($this->priceProductPriceListPageSearchBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testPublishAbstractPriceProductPriceList(): void
    {
        $this->priceProductPriceListPageSearchFacade->publishAbstractPriceProductPriceList([1]);
    }

    /**
     * @return void
     */
    public function testPublishAbstractPriceProductByByProductAbstractIds(): void
    {
        $this->priceProductPriceListPageSearchFacade->publishAbstractPriceProductByByProductAbstractIds([1]);
    }

    /**
     * @return void
     */
    public function testPublishConcretePriceProductByProductIds(): void
    {
        $this->priceProductPriceListPageSearchFacade->publishConcretePriceProductByProductIds([1]);
    }

    /**
     * @return void
     */
    public function testPublishConcretePriceProductPriceList(): void
    {
        $this->priceProductPriceListPageSearchFacade->publishConcretePriceProductPriceList([1]);
    }
}
