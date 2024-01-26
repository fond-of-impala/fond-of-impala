<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestCollaborativeCartsResponseAttributesMapperTest extends Unit
{
    protected MockObject|QuoteTransfer $quoteTransferMock;

    protected RestCollaborativeCartsResponseAttributesMapper $restCollaborativeCartsResponseAttributesMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCollaborativeCartsResponseAttributesMapper = new RestCollaborativeCartsResponseAttributesMapper();
    }

    /**
     * @return void
     */
    public function testFromQuote(): void
    {
        $uuid = '76ef8a63-c9f5-4994-bb35-3d6e5379c479';

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn($uuid);

        $restCollaborativeCartsResponseAttributesTransfer = $this->restCollaborativeCartsResponseAttributesMapper
            ->fromQuote($this->quoteTransferMock);

        static::assertEquals(
            $uuid,
            $restCollaborativeCartsResponseAttributesTransfer->getCartId(),
        );
    }
}
