<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacade;

class PriceListPriceProductStorePreDeletePluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension\PriceListPriceProductStorePreDeletePlugin
     */
    protected $priceListPriceProductStorePreDeletePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacade
     */
    protected $priceProductPriceListFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductPriceListFacadeMock = $this->getMockBuilder(PriceProductPriceListFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListPriceProductStorePreDeletePlugin = new PriceListPriceProductStorePreDeletePlugin();
        $this->priceListPriceProductStorePreDeletePlugin->setFacade($this->priceProductPriceListFacadeMock);
    }

    /**
     * @return void
     */
    public function testPreDelete(): void
    {
        $this->priceListPriceProductStorePreDeletePlugin->preDelete(1);
    }
}
