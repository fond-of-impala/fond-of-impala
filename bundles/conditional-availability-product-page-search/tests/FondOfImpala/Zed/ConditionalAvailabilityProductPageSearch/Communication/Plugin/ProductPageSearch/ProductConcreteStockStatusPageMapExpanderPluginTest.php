<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\ProductPageSearch;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;

class ProductConcreteStockStatusPageMapExpanderPluginTest extends Unit
{
    protected MockObject|LocaleTransfer $localTransferMock;

    protected MockObject|PageMapTransfer $pageMapTransferMock;

    protected MockObject|PageMapBuilderInterface $pageMapBuilderMock;

    protected ProductConcreteStockStatusPageMapExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->localTransferMock = $this->getMockBuilder(LocaleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pageMapTransferMock = $this->getMockBuilder(PageMapTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pageMapBuilderMock = $this->getMockBuilder(PageMapBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductConcreteStockStatusPageMapExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $productData = [ProductPageSearchTransfer::STOCK_STATUS => ['stock-status']];

        $this->pageMapTransferMock->expects(static::atLeastOnce())
            ->method('setStockStatus')
            ->with($productData[ProductPageSearchTransfer::STOCK_STATUS])
            ->willReturnSelf();

        $pageMapTransfer = $this->plugin->expand(
            $this->pageMapTransferMock,
            $this->pageMapBuilderMock,
            $productData,
            $this->localTransferMock,
        );

        static::assertEquals($this->pageMapTransferMock, $pageMapTransfer);
    }

    /**
     * @return void
     */
    public function testExpandWithNoStockStatus(): void
    {
        $productData = [];

        $pageMapTransfer = $this->plugin->expand(
            $this->pageMapTransferMock,
            $this->pageMapBuilderMock,
            $productData,
            $this->localTransferMock,
        );

        static::assertEquals($this->pageMapTransferMock, $pageMapTransfer);
    }
}
