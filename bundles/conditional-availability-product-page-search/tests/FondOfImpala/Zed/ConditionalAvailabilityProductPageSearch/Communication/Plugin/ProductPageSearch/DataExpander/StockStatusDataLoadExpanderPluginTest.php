<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\ProductPageSearch\DataExpander;

use Codeception\Test\Unit;
use Exception;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Generated\Shared\Transfer\ProductPayloadTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\ProductPageSearch\ProductPageSearchConfig;

class StockStatusDataLoadExpanderPluginTest extends Unit
{
    protected StockStatusDataLoadExpanderPlugin $expander;

    protected MockObject|ProductPageSearchTransfer $productAbstractPageSearchTransferMock;

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
        $self = $this;

        $productData = [ProductPageSearchConfig::PRODUCT_ABSTRACT_PAGE_LOAD_DATA => $this->productPayloadTransferMock];
        $stockStatus = ['stock-status'];

        $this->productPayloadTransferMock->expects(static::atLeastOnce())
            ->method('getStockStatus')
            ->willReturn($stockStatus);

        $callCount = $this->atLeastOnce();
        $this->productAbstractPageSearchTransferMock->expects($callCount)
            ->method('setStockStatus')
            ->willReturnCallback(static function (array $array) use ($self, $callCount, $stockStatus) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        $self->assertEquals([], $array);

                        return $self->productAbstractPageSearchTransferMock;
                    case 2:
                        $self->assertSame($stockStatus, $array);

                        return $self->productAbstractPageSearchTransferMock;
                }

                throw new Exception('Unexpected call count');
            });

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
