<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Claimer;

use Codeception\Test\Unit;
use FondOfImpala\Client\CollaborativeCartsRestApi\CollaborativeCartsRestApiClientInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiConfig;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilderInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestClaimCartRequestExpanderInterface;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestClaimCartRequestMapperInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartResponseTransfer;
use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CartClaimerTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestClaimCartRequestMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restClaimCartRequestMapperMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestClaimCartRequestExpanderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restClaimCartRequestExpanderMock;

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
     * @var \Generated\Shared\Transfer\RestClaimCartRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restClaimCartRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestClaimCartResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restClaimCartResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Claimer\CartClaimer
     */
    protected $cartClaimer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restClaimCartRequestMapperMock = $this->getMockBuilder(RestClaimCartRequestMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restClaimCartRequestExpanderMock = $this->getMockBuilder(RestClaimCartRequestExpanderInterface::class)
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

        $this->restClaimCartRequestTransferMock = $this->getMockBuilder(RestClaimCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restClaimCartResponseTransferMock = $this->getMockBuilder(RestClaimCartResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartClaimer = new CartClaimer(
            $this->restClaimCartRequestMapperMock,
            $this->restClaimCartRequestExpanderMock,
            $this->collaborativeCartRestResponseBuilderMock,
            $this->clientMock,
        );
    }

    /**
     * @return void
     */
    public function testClaim(): void
    {
        $this->restClaimCartRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestCollaborativeCartsRequestAttributes')
            ->with($this->restCollaborativeCartsRequestAttributesTransferMock)
            ->willReturn($this->restClaimCartRequestTransferMock);

        $this->restClaimCartRequestExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->restClaimCartRequestTransferMock)
            ->willReturn($this->restClaimCartRequestTransferMock);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('claimCart')
            ->with($this->restClaimCartRequestTransferMock)
            ->willReturn($this->restClaimCartResponseTransferMock);

        $this->restClaimCartResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->restClaimCartResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->collaborativeCartRestResponseBuilderMock->expects(static::never())
            ->method('createNotClaimedErrorResponse');

        $this->collaborativeCartRestResponseBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->with(CollaborativeCartsRestApiConfig::ACTION_CLAIM, $this->quoteTransferMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->cartClaimer->claim(
                $this->restRequestMock,
                $this->restCollaborativeCartsRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testClaimWithErrors(): void
    {
        $this->restClaimCartRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestCollaborativeCartsRequestAttributes')
            ->with($this->restCollaborativeCartsRequestAttributesTransferMock)
            ->willReturn($this->restClaimCartRequestTransferMock);

        $this->restClaimCartRequestExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->restClaimCartRequestTransferMock)
            ->willReturn($this->restClaimCartRequestTransferMock);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('claimCart')
            ->with($this->restClaimCartRequestTransferMock)
            ->willReturn($this->restClaimCartResponseTransferMock);

        $this->restClaimCartResponseTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn(null);

        $this->restClaimCartResponseTransferMock->expects(static::never())
            ->method('getIsSuccess');

        $this->collaborativeCartRestResponseBuilderMock->expects(static::atLeastOnce())
            ->method('createNotClaimedErrorResponse')
            ->willReturn($this->restResponseMock);

        $this->collaborativeCartRestResponseBuilderMock->expects(static::never())
            ->method('createRestResponse');

        static::assertEquals(
            $this->restResponseMock,
            $this->cartClaimer->claim(
                $this->restRequestMock,
                $this->restCollaborativeCartsRequestAttributesTransferMock,
            ),
        );
    }
}
