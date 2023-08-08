<?php

namespace FondOfImpala\Glue\PriceListsRestApi\Dependency\Client;

use Codeception\Test\Unit;
use FondOfImpala\Client\PriceList\PriceListClientInterface;
use Generated\Shared\Transfer\PriceListListTransfer;

class PriceListsRestApiToPriceListClientBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\PriceList\PriceListClientInterface
     */
    protected $priceListClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListListTransfer
     */
    protected $priceListListTransferMock;

    /**
     * @var \FondOfImpala\Glue\PriceListsRestApi\Dependency\Client\PriceListsRestApiToPriceListClientBridge
     */
    protected $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->priceListClientMock = $this->getMockBuilder(PriceListClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListListTransferMock = $this->getMockBuilder(PriceListListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new PriceListsRestApiToPriceListClientBridge(
            $this->priceListClientMock,
        );
    }

    /**
     * @return void
     */
    public function testFindPriceLists(): void
    {
        $this->priceListClientMock->expects(static::atLeastOnce())
            ->method('findPriceLists')
            ->with($this->priceListListTransferMock)
            ->willReturn($this->priceListListTransferMock);

        $this->assertEquals(
            $this->priceListListTransferMock,
            $this->bridge->findPriceLists(
                $this->priceListListTransferMock,
            ),
        );
    }
}
