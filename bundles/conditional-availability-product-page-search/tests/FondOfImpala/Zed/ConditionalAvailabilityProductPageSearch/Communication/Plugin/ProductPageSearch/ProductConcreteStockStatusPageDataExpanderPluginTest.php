<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\ProductPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ConditionalAvailabilityProductPageSearchFacade;
use Generated\Shared\Transfer\ProductConcretePageSearchTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductConcreteStockStatusPageDataExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ConditionalAvailabilityProductPageSearchFacade
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchFacade $facadeMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\ProductPageSearch\ProductConcreteStockStatusPageDataExpanderPlugin
     */
    protected ProductConcreteStockStatusPageDataExpanderPlugin $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected MockObject|ProductConcreteTransfer $productConcreteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcretePageSearchTransfer
     */
    protected MockObject|ProductConcretePageSearchTransfer $productConcretePageSearchTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcreteTransferMock = $this->getMockBuilder(ProductConcreteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcretePageSearchTransferMock = $this->getMockBuilder(ProductConcretePageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductConcreteStockStatusPageDataExpanderPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $idProductConcrete = 1;

        $this->productConcreteTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductConcrete')
            ->willReturn($idProductConcrete);

        $this->productConcretePageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setFkProduct')
            ->with($idProductConcrete)
            ->willReturnSelf();

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('expandProductConcretePageSearchTransferWithStockStatus')
            ->with($this->productConcretePageSearchTransferMock)
            ->willReturn($this->productConcretePageSearchTransferMock);

        $productConcretePageSearchTransfer = $this->plugin->expand(
            $this->productConcreteTransferMock,
            $this->productConcretePageSearchTransferMock,
        );

        static::assertEquals(
            $this->productConcretePageSearchTransferMock,
            $productConcretePageSearchTransfer,
        );
    }
}
