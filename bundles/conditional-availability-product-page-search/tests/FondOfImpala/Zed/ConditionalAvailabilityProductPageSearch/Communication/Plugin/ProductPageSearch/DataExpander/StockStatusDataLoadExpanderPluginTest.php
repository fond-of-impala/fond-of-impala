<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\ProductPageSearch\DataExpander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Generated\Shared\Transfer\ProductPayloadTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\ProductPageSearch\ProductPageSearchConfig;

class StockStatusDataLoadExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\ProductPageSearch\DataExpander\StockStatusDataLoadExpanderPlugin;
     */
    protected StockStatusDataLoadExpanderPlugin $expander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductPageSearchTransfer
     */
    protected MockObject|ProductPageSearchTransfer $productAbstractPageSearchTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductPayloadTransfer
     */
    protected MockObject|ProductPayloadTransfer $productPayloadTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productAbstractPageSearchTransferMock = $this->getMockBuilder(ProductPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productPayloadTransferMock = $this->getMockBuilder(ProductPayloadTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new StockStatusDataLoadExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandProductPageData(): void
    {
        $productData = [ProductPageSearchConfig::PRODUCT_ABSTRACT_PAGE_LOAD_DATA => $this->productPayloadTransferMock];
        $stockStatus = ['stock-status'];

        $this->productPayloadTransferMock->expects(static::atLeastOnce())
            ->method('getStockStatus')
            ->willReturn($stockStatus);

        $this->productAbstractPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setStockStatus')
            ->withConsecutive([], [$stockStatus])
            ->willReturnSelf();

        $this->expander->expandProductPageData($productData, $this->productAbstractPageSearchTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandProductPageDataWithNoStockStatus(): void
    {
        $productData = [ProductPageSearchConfig::PRODUCT_ABSTRACT_PAGE_LOAD_DATA => $this->productPayloadTransferMock];
        $stockStatus = [];

        $this->productPayloadTransferMock->expects(static::atLeastOnce())
            ->method('getStockStatus')
            ->willReturn($stockStatus);

        $this->productAbstractPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setStockStatus')
            ->with($stockStatus)
            ->willReturnSelf();

        $this->expander->expandProductPageData($productData, $this->productAbstractPageSearchTransferMock);
    }
}
