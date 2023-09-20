<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\ProductPageSearch\Elasticsearch;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;

class StockStatusMapExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PageMapTransfer
     */
    protected MockObject|LocaleTransfer $localTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PageMapTransfer
     */
    protected MockObject|PageMapTransfer $pageMapTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface
     */
    protected MockObject|PageMapBuilderInterface $pageMapBuilderMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\ProductPageSearch\Elasticsearch\StockStatusMapExpanderPlugin
     */
    protected StockStatusMapExpanderPlugin $plugin;

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

        $this->plugin = new StockStatusMapExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandProductMap(): void
    {
        $productData = ['stock_status' => ['stock-status']];

        $this->pageMapTransferMock->expects(static::atLeastOnce())
            ->method('setStockStatus')
            ->with($productData['stock_status'])
            ->willReturnSelf();

        $pageMapTransfer = $this->plugin->expandProductMap(
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
    public function testExpandProductMapWithNoStockStatus(): void
    {
        $productData = [];

        $pageMapTransfer = $this->plugin->expandProductMap(
            $this->pageMapTransferMock,
            $this->pageMapBuilderMock,
            $productData,
            $this->localTransferMock,
        );

        static::assertEquals($this->pageMapTransferMock, $pageMapTransfer);
    }
}
