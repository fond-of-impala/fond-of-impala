<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacade;
use PHPUnit\Framework\MockObject\MockObject;

class PriceListPriceProductStorePreDeletePluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Communication\Plugin\PriceProductExtension\PriceListPriceProductStorePreDeletePlugin
     */
    protected PriceListPriceProductStorePreDeletePlugin $priceListPriceProductStorePreDeletePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Business\PriceProductPriceListFacade
     */
    protected MockObject|PriceProductPriceListFacade $priceProductPriceListFacadeMock;

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
