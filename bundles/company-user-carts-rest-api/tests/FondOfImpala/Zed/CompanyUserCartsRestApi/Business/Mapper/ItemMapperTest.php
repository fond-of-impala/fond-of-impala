<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestCartItemTransfer;

class ItemMapperTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\RestCartItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCartItemTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\ItemMapper
     */
    protected $itemMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restCartItemTransferMock = $this->getMockBuilder(RestCartItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemMapper = new ItemMapper();
    }

    /**
     * @return void
     */
    public function testFromRestCartItem(): void
    {
        $data = [
            'sku' => 'foo-bar-1',
            'quantity' => 1,
        ];

        $this->restCartItemTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn($data);

        $itemTransfer = $this->itemMapper->fromRestCartItem($this->restCartItemTransferMock);

        static::assertEquals(
            $data['sku'],
            $itemTransfer->getSku(),
        );

        static::assertEquals(
            $data['quantity'],
            $itemTransfer->getQuantity(),
        );
    }
}
