<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\CollaborativeCart;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiConfig;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilderInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Claimer\CartClaimerInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Releaser\CartReleaserInterface;
use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CollaborativeCartProcessorTest extends Unit
{
    protected MockObject|RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransferMock;

    protected MockObject|RestRequestInterface $restRequestMock;

    protected MockObject|CollaborativeCartRestResponseBuilderInterface $collaborativeCartRestResponseBuilderMock;

    protected MockObject|CartClaimerInterface $cartClaimerMock;

    protected MockObject|CartReleaserInterface $cartReleaserMock;

    protected MockObject|RestResponseInterface $restResponseMock;

    protected CollaborativeCartProcessor $collaborativeCartProcessor;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restCollaborativeCartsRequestAttributesTransferMock = $this->getMockBuilder(RestCollaborativeCartsRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartRestResponseBuilderMock = $this->getMockBuilder(CollaborativeCartRestResponseBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartClaimerMock = $this->getMockBuilder(CartClaimerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartReleaserMock = $this->getMockBuilder(CartReleaserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartProcessor = new CollaborativeCartProcessor(
            $this->collaborativeCartRestResponseBuilderMock,
            $this->cartClaimerMock,
            $this->cartReleaserMock,
        );
    }

    /**
     * @return void
     */
    public function testProcessForClaimAction(): void
    {
        $cartId = '0e3bc0e0-c2cd-4d3c-b9d7-83988efdf4ac';

        $this->restCollaborativeCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCartId')
            ->willReturn($cartId);

        $this->collaborativeCartRestResponseBuilderMock->expects(static::never())
            ->method('createCartIdMissingErrorResponse');

        $this->restCollaborativeCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getAction')
            ->willReturn(CollaborativeCartsRestApiConfig::ACTION_CLAIM);

        $this->cartClaimerMock->expects(static::atLeastOnce())
            ->method('claim')
            ->with($this->restRequestMock, $this->restCollaborativeCartsRequestAttributesTransferMock)
            ->willReturn($this->restResponseMock);

        $this->cartReleaserMock->expects(static::never())
            ->method('release');

        $this->collaborativeCartRestResponseBuilderMock->expects(static::never())
            ->method('createInvalidActionErrorResponse');

        static::assertEquals(
            $this->restResponseMock,
            $this->collaborativeCartProcessor->process(
                $this->restRequestMock,
                $this->restCollaborativeCartsRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testProcessForReleaseAction(): void
    {
        $cartId = '0e3bc0e0-c2cd-4d3c-b9d7-83988efdf4ac';

        $this->restCollaborativeCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCartId')
            ->willReturn($cartId);

        $this->collaborativeCartRestResponseBuilderMock->expects(static::never())
            ->method('createCartIdMissingErrorResponse');

        $this->restCollaborativeCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getAction')
            ->willReturn(CollaborativeCartsRestApiConfig::ACTION_RELEASE);

        $this->cartClaimerMock->expects(static::never())
            ->method('claim');

        $this->cartReleaserMock->expects(static::atLeastOnce())
            ->method('release')
            ->with($this->restRequestMock, $this->restCollaborativeCartsRequestAttributesTransferMock)
            ->willReturn($this->restResponseMock);

        $this->collaborativeCartRestResponseBuilderMock->expects(static::never())
            ->method('createInvalidActionErrorResponse');

        static::assertEquals(
            $this->restResponseMock,
            $this->collaborativeCartProcessor->process(
                $this->restRequestMock,
                $this->restCollaborativeCartsRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testProcessWithoutCartId(): void
    {
        $this->restCollaborativeCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCartId')
            ->willReturn(null);

        $this->collaborativeCartRestResponseBuilderMock->expects(static::atLeastOnce())
            ->method('createCartIdMissingErrorResponse')
            ->willReturn($this->restResponseMock);

        $this->restCollaborativeCartsRequestAttributesTransferMock->expects(static::never())
            ->method('getAction');

        $this->cartClaimerMock->expects(static::never())
            ->method('claim');

        $this->cartReleaserMock->expects(static::never())
            ->method('release');

        $this->collaborativeCartRestResponseBuilderMock->expects(static::never())
            ->method('createInvalidActionErrorResponse');

        static::assertEquals(
            $this->restResponseMock,
            $this->collaborativeCartProcessor->process(
                $this->restRequestMock,
                $this->restCollaborativeCartsRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testProcessForInvalidAction(): void
    {
        $cartId = '0e3bc0e0-c2cd-4d3c-b9d7-83988efdf4ac';

        $this->restCollaborativeCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCartId')
            ->willReturn($cartId);

        $this->collaborativeCartRestResponseBuilderMock->expects(static::never())
            ->method('createCartIdMissingErrorResponse');

        $this->restCollaborativeCartsRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getAction')
            ->willReturn('xxx');

        $this->cartReleaserMock->expects(static::never())
            ->method('release');

        $this->cartClaimerMock->expects(static::never())
            ->method('claim');

        $this->collaborativeCartRestResponseBuilderMock->expects(static::atLeastOnce())
            ->method('createInvalidActionErrorResponse')
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->collaborativeCartProcessor->process(
                $this->restRequestMock,
                $this->restCollaborativeCartsRequestAttributesTransferMock,
            ),
        );
    }
}
