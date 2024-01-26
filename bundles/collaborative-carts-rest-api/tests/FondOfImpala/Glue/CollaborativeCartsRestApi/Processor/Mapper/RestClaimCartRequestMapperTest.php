<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestClaimCartRequestMapperTest extends Unit
{
    protected MockObject|RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransferMock;

    protected RestClaimCartRequestMapper $restClaimCartRequestMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restCollaborativeCartsRequestAttributesTransferMock = $this->getMockBuilder(RestCollaborativeCartsRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restClaimCartRequestMapper = new RestClaimCartRequestMapper();
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

        $restClaimCartRequestTransfer = $this->restClaimCartRequestMapper->fromRestCollaborativeCartsRequestAttributes(
            $this->restCollaborativeCartsRequestAttributesTransferMock,
        );

        static::assertEquals(
            $cartId,
            $restClaimCartRequestTransfer->getQuoteUuid(),
        );
    }
}
