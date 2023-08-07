<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Shared\PriceProductPriceList\PriceProductPriceListConstants;
use FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceListFacadeInterface;
use Generated\Shared\Transfer\PriceListTransfer;
use Generated\Shared\Transfer\PriceProductDimensionTransfer;

class PriceProductDimensionExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Business\Model\PriceProductDimensionExpander
     */
    protected $priceProductDimensionExpander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceListFacadeInterface
     */
    protected $priceListFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    protected $priceProductDimensionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListTransfer
     */
    protected $priceListTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceListFacadeMock = $this->getMockBuilder(PriceProductPriceListToPriceListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductDimensionTransferMock = $this->getMockBuilder(PriceProductDimensionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListTransferMock = $this->getMockBuilder(PriceListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductDimensionExpander = new PriceProductDimensionExpander(
            $this->priceListFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->priceProductDimensionTransferMock->expects($this->atLeastOnce())
            ->method('getIdPriceList')
            ->willReturn(1);

        $this->priceListFacadeMock->expects($this->atLeastOnce())
            ->method('findPriceListById')
            ->willReturn($this->priceListTransferMock);

        $this->priceProductDimensionTransferMock->expects($this->atLeastOnce())
            ->method('setType')
            ->with(PriceProductPriceListConstants::PRICE_DIMENSION_PRICE_LIST)
            ->willReturn($this->priceProductDimensionTransferMock);

        $this->priceProductDimensionTransferMock->expects($this->atLeastOnce())
            ->method('setName')
            ->willReturn($this->priceProductDimensionTransferMock);

        $this->priceListTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('name');

        $this->assertInstanceOf(PriceProductDimensionTransfer::class, $this->priceProductDimensionExpander->expand($this->priceProductDimensionTransferMock));
    }

    /**
     * @return void
     */
    public function testExpandNull(): void
    {
        $this->priceProductDimensionTransferMock->expects($this->atLeastOnce())
            ->method('getIdPriceList')
            ->willReturn(1);

        $this->priceListFacadeMock->expects($this->atLeastOnce())
            ->method('findPriceListById')
            ->willReturn(null);

        $this->assertInstanceOf(PriceProductDimensionTransfer::class, $this->priceProductDimensionExpander->expand($this->priceProductDimensionTransferMock));
    }
}
