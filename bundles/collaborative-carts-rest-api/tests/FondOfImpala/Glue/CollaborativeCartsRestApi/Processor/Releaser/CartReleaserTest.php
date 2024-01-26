<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Releaser;

use Codeception\Test\Unit;
use FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiClientInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiConfig;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilderInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestReleaseCartRequestExpanderInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestReleaseCartRequestMapperInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CartReleaserTest extends Unit
{
    protected MockObject|RestReleaseCartRequestMapperInterface $restReleaseCartRequestMapperMock;

    protected MockObject|RestReleaseCartRequestExpanderInterface $restReleaseCartRequestExpanderMock;

    protected MockObject|CollaborativeCartRestResponseBuilderInterface $collaborativeCartRestResponseBuilderMock;

    protected MockObject|CollaborativeCartsRestApiClientInterface $clientMock;

    protected MockObject|RestRequestInterface $restRequestMock;

    protected MockObject|RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransferMock;

    protected MockObject|RestReleaseCartRequestTransfer $restReleaseCartRequestTransferMock;

    protected MockObject|RestReleaseCartResponseTransfer $restReleaseCartResponseTransferMock;

    protected MockObject|QuoteTransfer $quoteTransferMock;

    protected MockObject|RestResponseInterface $restResponseMock;

    protected CartReleaser $cartReleaser;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restReleaseCartRequestMapperMock = $this->getMockBuilder(RestReleaseCartRequestMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restReleaseCartRequestExpanderMock = $this->getMockBuilder(RestReleaseCartRequestExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartRestResponseBuilderMock = $this->getMockBuilder(CollaborativeCartRestResponseBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(CollaborativeCartsRestApiClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCollaborativeCartsRequestAttributesTransferMock = $this->getMockBuilder(RestCollaborativeCartsRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restReleaseCartRequestTransferMock = $this->getMockBuilder(RestReleaseCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restReleaseCartResponseTransferMock = $this->getMockBuilder(RestReleaseCartResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartReleaser = new CartReleaser(
            $this->restReleaseCartRequestMapperMock,
            $this->restReleaseCartRequestExpanderMock,
            $this->collaborativeCartRestResponseBuilderMock,
            $this->clientMock,
        );
    }

    /**
     * @return void
     */
    public function testRelease(): void
    {
        $this->restReleaseCartRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestCollaborativeCartsRequestAttributes')
            ->with($this->restCollaborativeCartsRequestAttributesTransferMock)
            ->willReturn($this->restReleaseCartRequestTransferMock);

        $this->restReleaseCartRequestExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->restReleaseCartRequestTransferMock)
            ->willReturn($this->restReleaseCartRequestTransferMock);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('releaseCart')
            ->with($this->restReleaseCartRequestTransferMock)
            ->willReturn($this->restReleaseCartResponseTransferMock);

        $this->restReleaseCartResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->restReleaseCartResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->collaborativeCartRestResponseBuilderMock->expects(static::never())
            ->method('createNotReleasedErrorResponse');

        $this->collaborativeCartRestResponseBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->with(CollaborativeCartsRestApiConfig::ACTION_RELEASE, $this->quoteTransferMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->cartReleaser->release(
                $this->restRequestMock,
                $this->restCollaborativeCartsRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testReleaseWithErrors(): void
    {
        $this->restReleaseCartRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestCollaborativeCartsRequestAttributes')
            ->with($this->restCollaborativeCartsRequestAttributesTransferMock)
            ->willReturn($this->restReleaseCartRequestTransferMock);

        $this->restReleaseCartRequestExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->restReleaseCartRequestTransferMock)
            ->willReturn($this->restReleaseCartRequestTransferMock);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('releaseCart')
            ->with($this->restReleaseCartRequestTransferMock)
            ->willReturn($this->restReleaseCartResponseTransferMock);

        $this->restReleaseCartResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn(null);

        $this->restReleaseCartResponseTransferMock->expects(static::never())
            ->method('getIsSuccess');

        $this->collaborativeCartRestResponseBuilderMock->expects(static::atLeastOnce())
            ->method('createNotReleasedErrorResponse')
            ->willReturn($this->restResponseMock);

        $this->collaborativeCartRestResponseBuilderMock->expects(static::never())
            ->method('createRestResponse');

        static::assertEquals(
            $this->restResponseMock,
            $this->cartReleaser->release(
                $this->restRequestMock,
                $this->restCollaborativeCartsRequestAttributesTransferMock,
            ),
        );
    }
}
