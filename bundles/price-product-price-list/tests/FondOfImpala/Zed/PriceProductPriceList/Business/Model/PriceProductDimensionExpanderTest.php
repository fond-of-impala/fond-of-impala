<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Shared\PriceProductPriceList\PriceProductPriceListConstants;
use FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceListFacadeInterface;
use Generated\Shared\Transfer\PriceListTransfer;
use Generated\Shared\Transfer\PriceProductDimensionTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceProductDimensionExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceList\Business\Model\PriceProductDimensionExpander
     */
    protected PriceProductDimensionExpander $priceProductDimensionExpander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade\PriceProductPriceListToPriceListFacadeInterface
     */
    protected MockObject|PriceProductPriceListToPriceListFacadeInterface $priceListFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    protected MockObject|PriceProductDimensionTransfer $priceProductDimensionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListTransfer
     */
    protected MockObject|PriceListTransfer $priceListTransferMock;

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
        $this->priceProductDimensionTransferMock->expects(static::atLeastOnce())
            ->method('getIdPriceList')
            ->willReturn(1);

        $this->priceListFacadeMock->expects(static::atLeastOnce())
            ->method('findPriceListById')
            ->willReturn($this->priceListTransferMock);

        $this->priceProductDimensionTransferMock->expects(static::atLeastOnce())
            ->method('setType')
            ->with(PriceProductPriceListConstants::PRICE_DIMENSION_PRICE_LIST)
            ->willReturn($this->priceProductDimensionTransferMock);

        $this->priceProductDimensionTransferMock->expects(static::atLeastOnce())
            ->method('setName')
            ->willReturn($this->priceProductDimensionTransferMock);

        $this->priceListTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn('name');

        static::assertInstanceOf(PriceProductDimensionTransfer::class, $this->priceProductDimensionExpander->expand($this->priceProductDimensionTransferMock));
    }

    /**
     * @return void
     */
    public function testExpandNull(): void
    {
        $this->priceProductDimensionTransferMock->expects(static::atLeastOnce())
            ->method('getIdPriceList')
            ->willReturn(1);

        $this->priceListFacadeMock->expects(static::atLeastOnce())
            ->method('findPriceListById')
            ->willReturn(null);

        static::assertInstanceOf(PriceProductDimensionTransfer::class, $this->priceProductDimensionExpander->expand($this->priceProductDimensionTransferMock));
    }
}
