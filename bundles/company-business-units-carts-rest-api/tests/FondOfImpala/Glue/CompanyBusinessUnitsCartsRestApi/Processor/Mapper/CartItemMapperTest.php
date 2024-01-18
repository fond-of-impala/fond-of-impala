<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestCartItemCalculationsTransfer;
use Generated\Shared\Transfer\RestItemsAttributesTransfer;

class CartItemMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestItemsAttributesTransfer
     */
    protected $restItemsAttributesTransferMock;

    /**
     * @var string
     */
    protected $localeName;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCartItemCalculationsTransfer
     */
    protected $restCartItemCalculationsTransferMock;

    /**
     * @var \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartItemMapper
     */
    protected $cartItemMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restItemsAttributesTransferMock = $this->getMockBuilder(RestItemsAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartItemCalculationsTransferMock = $this->getMockBuilder(RestCartItemCalculationsTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeName = 'de_DE';

        $this->cartItemMapper = new CartItemMapper();
    }

    /**
     * @return void
     */
    public function testMapItemTransferToRestItemsAttributesTransfer(): void
    {
        $itemTransferData = [];

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn($itemTransferData);

        $this->restItemsAttributesTransferMock->expects(static::atLeastOnce())
            ->method('fromArray')
            ->with($itemTransferData, true)
            ->willReturn($this->restItemsAttributesTransferMock);

        $this->restItemsAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCalculations')
            ->willReturn(null);

        $this->restItemsAttributesTransferMock->expects(static::atLeastOnce())
            ->method('setCalculations')
            ->with(static::isInstanceOf(RestCartItemCalculationsTransfer::class))
            ->willReturn($this->restItemsAttributesTransferMock);

        static::assertEquals(
            $this->restItemsAttributesTransferMock,
            $this->cartItemMapper->mapItemTransferToRestItemsAttributesTransfer(
                $this->itemTransferMock,
                $this->restItemsAttributesTransferMock,
                $this->localeName,
            ),
        );
    }
}
