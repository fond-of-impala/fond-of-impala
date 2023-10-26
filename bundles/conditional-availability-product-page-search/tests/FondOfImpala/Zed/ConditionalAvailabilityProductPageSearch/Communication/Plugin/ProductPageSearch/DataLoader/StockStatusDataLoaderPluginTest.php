<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\ProductPageSearch\DataLoader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ConditionalAvailabilityProductPageSearchFacade;
use Generated\Shared\Transfer\ProductPageLoadTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class StockStatusDataLoaderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\ProductPageSearch\DataLoader\StockStatusDataLoaderPlugin;
     */
    protected StockStatusDataLoaderPlugin $expander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ConditionalAvailabilityProductPageSearchFacade
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchFacade $facadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductPageLoadTransfer
     */
    protected MockObject|ProductPageLoadTransfer $pageLoadTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pageLoadTransferMock = $this->getMockBuilder(ProductPageLoadTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new StockStatusDataLoaderPlugin();
        $this->expander->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testExpandProductPageDataTransfer(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('expandProductPageData')
            ->with($this->pageLoadTransferMock)
            ->willReturn($this->pageLoadTransferMock);

        $pageLoadTransferMock = $this->expander->expandProductPageDataTransfer($this->pageLoadTransferMock);

        static::assertEquals($this->pageLoadTransferMock, $pageLoadTransferMock);
    }
}
