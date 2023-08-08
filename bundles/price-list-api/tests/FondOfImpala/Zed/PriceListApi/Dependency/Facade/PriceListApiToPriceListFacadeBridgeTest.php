<?php

namespace FondOfImpala\Zed\PriceListApi\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceList\Business\PriceListFacade;
use Generated\Shared\Transfer\PriceListTransfer;

class PriceListApiToPriceListFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceList\Business\PriceListFacade
     */
    protected $priceListFacadeMock;

    /**
     * @var \FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceListFacadeBridge
     */
    protected $priceListApiToPriceListFacadeBridge;

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

        $this->priceListFacadeMock = $this->getMockBuilder(PriceListFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListTransferMock = $this->getMockBuilder(PriceListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListApiToPriceListFacadeBridge = new PriceListApiToPriceListFacadeBridge($this->priceListFacadeMock);
    }

    /**
     * @return void
     */
    public function testFindPriceListByName(): void
    {
        $this->priceListFacadeMock->expects(static::atLeastOnce())
            ->method('findPriceListByName')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        static::assertEquals(
            $this->priceListTransferMock,
            $this->priceListApiToPriceListFacadeBridge->findPriceListByName($this->priceListTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testCreatePriceList(): void
    {
        $this->priceListFacadeMock->expects(static::atLeastOnce())
            ->method('createPriceList')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        static::assertEquals(
            $this->priceListTransferMock,
            $this->priceListApiToPriceListFacadeBridge->createPriceList($this->priceListTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testUpdatePriceList(): void
    {
        $this->priceListFacadeMock->expects(static::atLeastOnce())
            ->method('updatePriceList')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        static::assertEquals(
            $this->priceListTransferMock,
            $this->priceListApiToPriceListFacadeBridge->updatePriceList($this->priceListTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFindPriceListById(): void
    {
        $this->priceListFacadeMock->expects(static::atLeastOnce())
            ->method('findPriceListById')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        static::assertEquals(
            $this->priceListTransferMock,
            $this->priceListApiToPriceListFacadeBridge->findPriceListById($this->priceListTransferMock),
        );
    }
}
