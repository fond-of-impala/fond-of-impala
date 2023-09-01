<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\PriceProductPriceListPageSearchExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchFacade;
use Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class ProductListPriceProductAbstractPriceListPageDataExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\PriceProductPriceListPageSearchExtension\ProductListPriceProductAbstractPriceListPageDataExpanderPlugin
     */
    protected ProductListPriceProductAbstractPriceListPageDataExpanderPlugin $productListPriceProductAbstractPriceListPageDataExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchFacade
     */
    protected MockObject|ProductListPriceProductPriceListPageSearchFacade $productListPriceProductPriceListPageSearchFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductPriceListPageSearchTransfer
     */
    protected MockObject|PriceProductPriceListPageSearchTransfer $priceProductPriceListPageSearchTransferMock;

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

        $this->productListPriceProductAbstractPriceListPageDataExpanderPlugin = new class (
            $this->productListPriceProductPriceListPageSearchFacadeInterfaceMock
        ) extends ProductListPriceProductAbstractPriceListPageDataExpanderPlugin {
            protected ProductListPriceProductPriceListPageSearchFacade $productListPriceProductPriceListPageSearchFacade;

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
            ->method('expandPriceProductAbstractPriceListPageSearchWithProductLists')
            ->with($this->priceProductPriceListPageSearchTransferMock)
            ->willReturn($this->priceProductPriceListPageSearchTransferMock);

        self::assertEquals(
            $this->priceProductPriceListPageSearchTransferMock,
            $this->productListPriceProductAbstractPriceListPageDataExpanderPlugin->expand(
                $this->priceProductPriceListPageSearchTransferMock,
            ),
        );
    }
}
