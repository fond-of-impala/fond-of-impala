<?php

namespace FondOfImpala\Glue\PriceListsRestApi\Processor\PriceList;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceListTransfer;
use Generated\Shared\Transfer\RestPriceListAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceListMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\PriceListsRestApi\Processor\PriceList\PriceListMapper
     */
    protected PriceListMapper $priceListMapper;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListTransfer
     */
    protected MockObject|PriceListTransfer $priceListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestPriceListAttributesTransfer
     */
    protected MockObject|RestPriceListAttributesTransfer $restPriceListAttributesTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->priceListTransferMock = $this->getMockBuilder(PriceListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restPriceListAttributesTransferMock = $this->getMockBuilder(RestPriceListAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListMapper = new PriceListMapper();
    }

    /**
     * @return void
     */
    public function testMapPriceListTransferToRestPriceListAttributesTransfer(): void
    {
        $this->priceListTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->restPriceListAttributesTransferMock->expects(static::atLeastOnce())
            ->method('fromArray')
            ->with([], true)
            ->willReturnSelf();

        static::assertEquals(
            $this->restPriceListAttributesTransferMock,
            $this->priceListMapper->mapPriceListTransferToRestPriceListAttributesTransfer(
                $this->priceListTransferMock,
                $this->restPriceListAttributesTransferMock,
            ),
        );
    }
}
