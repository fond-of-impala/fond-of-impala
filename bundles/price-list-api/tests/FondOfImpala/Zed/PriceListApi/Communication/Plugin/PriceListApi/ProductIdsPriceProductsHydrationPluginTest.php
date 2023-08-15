<?php

namespace FondOfImpala\Zed\PriceListApi\Communication\Plugin\PriceListApi;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacade;
use Generated\Shared\Transfer\PriceProductTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductIdsPriceProductsHydrationPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacade
     */
    protected MockObject|PriceListApiFacade $priceListApiFacadeMock;

    /**
     * @var array<\Generated\Shared\Transfer\PriceProductTransfer>|array<\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $priceProductTransferMocks;

    /**
     * @var \FondOfImpala\Zed\PriceListApi\Communication\Plugin\PriceListApi\ProductIdsPriceProductsHydrationPlugin
     */
    protected ProductIdsPriceProductsHydrationPlugin $productIdsPriceProductsHydrationPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceListApiFacadeMock = $this->getMockBuilder(PriceListApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductTransferMocks = [
            $this->getMockBuilder(PriceProductTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->productIdsPriceProductsHydrationPlugin = new ProductIdsPriceProductsHydrationPlugin();
        $this->productIdsPriceProductsHydrationPlugin->setFacade($this->priceListApiFacadeMock);
    }

    /**
     * @return void
     */
    public function testHydrate(): void
    {
        $this->priceListApiFacadeMock->expects(static::atLeastOnce())
            ->method('hydratePriceProductsWithProductIds')
            ->with($this->priceProductTransferMocks)
            ->willReturn($this->priceProductTransferMocks);

        static::assertEquals(
            $this->priceProductTransferMocks,
            $this->productIdsPriceProductsHydrationPlugin->hydrate($this->priceProductTransferMocks),
        );
    }
}
