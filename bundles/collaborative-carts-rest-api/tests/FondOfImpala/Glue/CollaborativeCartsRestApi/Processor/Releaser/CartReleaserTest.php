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
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CartReleaserTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestReleaseCartRequestMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restReleaseCartRequestMapperMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestReleaseCartRequestExpanderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restReleaseCartRequestExpanderMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $collaborativeCartRestResponseBuilderMock;

    /**
     * @var \FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $clientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCollaborativeCartsRequestAttributesTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestReleaseCartRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restReleaseCartRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestReleaseCartResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restReleaseCartResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Releaser\CartReleaser
     */
    protected $cartReleaser;

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
