<?php

namespace FondOfImpala\Client\PriceList;

use Codeception\Test\Unit;
use FondOfImpala\Client\PriceList\Zed\PriceListStubInterface;
use Generated\Shared\Transfer\PriceListListTransfer;

class PriceListClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\PriceList\PriceListFactory|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $factoryMock;

    /**
     * @var \FondOfImpala\Client\PriceList\Zed\PriceListStubInterface|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $zedStubMock;

    /**
     * @var \Generated\Shared\Transfer\PriceListListTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $priceListListTransferMock;

    /**
     * @var \FondOfImpala\Client\PriceList\PriceListClient
     */
    protected $client;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(PriceListFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedStubMock = $this->getMockBuilder(PriceListStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListListTransferMock = $this->getMockBuilder(PriceListListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new PriceListClient();
        $this->client->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testFindPriceLists(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createZedPriceListStub')
            ->willReturn($this->zedStubMock);

        $this->zedStubMock->expects(static::atLeastOnce())
            ->method('findPriceLists')
            ->with($this->priceListListTransferMock)
            ->willReturn($this->priceListListTransferMock);

        static::assertEquals(
            $this->priceListListTransferMock,
            $this->client->findPriceLists($this->priceListListTransferMock),
        );
    }
}
