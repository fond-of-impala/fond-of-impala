<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;

class RestReleaseCartRequestMapperTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCollaborativeCartsRequestAttributesTransferMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestReleaseCartRequestMapper
     */
    protected $restReleaseCartRequestMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restCollaborativeCartsRequestAttributesTransferMock = $this->getMockBuilder(RestCollaborativeCartsRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restReleaseCartRequestMapper = new RestReleaseCartRequestMapper();
    }

    /**
     * @return void
     */
    public function testFromRestCollaborativeCartsRequestAttributes(): void
    {
        $cartId = '76ef8a63-c9f5-4994-bb35-3d6e5379c479';

        $this->restCollaborativeCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCartId')
            ->willReturn($cartId);

        $restReleaseCartRequestTransfer = $this->restReleaseCartRequestMapper->fromRestCollaborativeCartsRequestAttributes(
            $this->restCollaborativeCartsRequestAttributesTransferMock,
        );

        static::assertEquals(
            $cartId,
            $restReleaseCartRequestTransfer->getQuoteUuid(),
        );
    }
}
