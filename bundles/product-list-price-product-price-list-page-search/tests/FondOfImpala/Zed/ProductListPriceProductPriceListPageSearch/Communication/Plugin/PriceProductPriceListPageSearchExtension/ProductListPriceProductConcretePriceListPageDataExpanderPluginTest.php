<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\PriceProductPriceListPageSearchExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchFacade;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class ProductListPriceProductConcretePriceListPageDataExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\PriceProductPriceListPageSearchExtension\ProductListPriceProductConcretePriceListPageDataExpanderPlugin
     */
    protected $productListPriceProductConcretePriceListPageDataExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchFacade
     */
    protected $productListPriceProductPriceListPageSearchFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    protected $priceProductPriceListPageSearchTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListPriceProductPriceListPageSearchFacadeInterfaceMock = $this->getMockBuilder(ProductListPriceProductPriceListPageSearchFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchTransferMock = $this->getMockBuilder(PriceProductPriceListPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListPriceProductConcretePriceListPageDataExpanderPlugin = new class (
            $this->productListPriceProductPriceListPageSearchFacadeInterfaceMock
        ) extends ProductListPriceProductConcretePriceListPageDataExpanderPlugin {
            /**
             * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchFacade
             */
            protected $productListPriceProductPriceListPageSearchFacade;

            /**
             * @param \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchFacade $productListPriceProductPriceListPageSearchFacade
             */
            public function __construct(ProductListPriceProductPriceListPageSearchFacade $productListPriceProductPriceListPageSearchFacade)
            {
                $this->productListPriceProductPriceListPageSearchFacade = $productListPriceProductPriceListPageSearchFacade;
            }

            /**
             * @return \Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected function getFacade(): AbstractFacade
            {
                return $this->productListPriceProductPriceListPageSearchFacade;
            }
        };
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->productListPriceProductPriceListPageSearchFacadeInterfaceMock->expects(self::atLeastOnce())
            ->method('expandPriceProductConcretePriceListPageSearchWithProductLists')
            ->with($this->priceProductPriceListPageSearchTransferMock)
            ->willReturn($this->priceProductPriceListPageSearchTransferMock);

        self::assertEquals(
            $this->priceProductPriceListPageSearchTransferMock,
            $this->productListPriceProductConcretePriceListPageDataExpanderPlugin->expand(
                $this->priceProductPriceListPageSearchTransferMock,
            ),
        );
    }
}
