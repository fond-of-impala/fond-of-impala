<?php

namespace FondOfImpala\Client\PriceList\Zed;

use Codeception\Test\Unit;
use FondOfImpala\Client\PriceList\Dependency\Client\PriceListToZedRequestClientInterface;
use Generated\Shared\Transfer\PriceListListTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceListStubTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\PriceListListTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|PriceListListTransfer $priceListListTransferMock;

    /**
     * @var \FondOfImpala\Client\PriceList\Dependency\Client\PriceListToZedRequestClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|PriceListToZedRequestClientInterface $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\PriceList\Zed\PriceListStub
     */
    protected PriceListStub $priceListStub;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceListListTransferMock = $this->getMockBuilder(PriceListListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(PriceListToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListStub = new PriceListStub($this->zedRequestClientMock);
    }

    /**
     * @return void
     */
    public function testFindPriceLists(): void
    {
        $this->zedRequestClientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with(
                '/price-list/gateway/find-price-lists',
                $this->priceListListTransferMock,
            )->willReturn($this->priceListListTransferMock);

        static::assertEquals(
            $this->priceListListTransferMock,
            $this->priceListStub->findPriceLists($this->priceListListTransferMock),
        );
    }
}
