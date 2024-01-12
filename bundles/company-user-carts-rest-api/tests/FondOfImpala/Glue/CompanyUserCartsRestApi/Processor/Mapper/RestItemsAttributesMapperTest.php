<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;

class RestItemsAttributesMapperTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $itemTransferMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestItemsAttributesMapper
     */
    protected $restItemsAttributesMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restItemsAttributesMapper = new RestItemsAttributesMapper();
    }

    /**
     * @return void
     */
    public function testFromItem(): void
    {
        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $restItemsAttributesTransfer = $this->restItemsAttributesMapper->fromItem($this->itemTransferMock);

        static::assertNotEquals(
            null,
            $restItemsAttributesTransfer->getCalculations(),
        );
    }
}
