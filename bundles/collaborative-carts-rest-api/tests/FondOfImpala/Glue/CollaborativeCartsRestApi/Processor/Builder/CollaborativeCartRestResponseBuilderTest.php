<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiConfig;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestCollaborativeCartsResponseAttributesMapperInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCollaborativeCartsResponseAttributesTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class CollaborativeCartRestResponseBuilderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Mapper\RestCollaborativeCartsResponseAttributesMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCollaborativeCartsResponseAttributesMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCollaborativeCartsResponseAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCollaborativeCartsResponseAttributesTransferMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Builder\CollaborativeCartRestResponseBuilder
     */
    protected $collaborativeCartRestResponseBuilder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCollaborativeCartsResponseAttributesTransferMock = $this->getMockBuilder(RestCollaborativeCartsResponseAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCollaborativeCartsResponseAttributesMapperMock = $this->getMockBuilder(RestCollaborativeCartsResponseAttributesMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartRestResponseBuilder = new CollaborativeCartRestResponseBuilder(
            $this->restResourceBuilderMock,
            $this->restCollaborativeCartsResponseAttributesMapperMock,
        );
    }

    /**
     * @return void
     */
    public function testCreateInvalidActionErrorResponse(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->with(
                static::callback(
                    static function (RestErrorMessageTransfer $restErrorMessageTransfer) {
                        return $restErrorMessageTransfer->getStatus() === Response::HTTP_BAD_REQUEST
                        && $restErrorMessageTransfer->getCode() === CollaborativeCartsRestApiConfig::RESPONSE_CODE_INVALID_ACTION
                        && $restErrorMessageTransfer->getDetail() === CollaborativeCartsRestApiConfig::RESPONSE_DETAIL_INVALID_ACTION;
                    },
                ),
            )
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->collaborativeCartRestResponseBuilder->createInvalidActionErrorResponse(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCartIdMissingErrorResponse(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->with(
                static::callback(
                    static function (RestErrorMessageTransfer $restErrorMessageTransfer) {
                        return $restErrorMessageTransfer->getStatus() === Response::HTTP_BAD_REQUEST
                            && $restErrorMessageTransfer->getCode() === CollaborativeCartsRestApiConfig::RESPONSE_CODE_CART_ID_MISSING
                            && $restErrorMessageTransfer->getDetail() === CollaborativeCartsRestApiConfig::RESPONSE_DETAIL_CART_ID_MISSING;
                    },
                ),
            )
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->collaborativeCartRestResponseBuilder->createCartIdMissingErrorResponse(),
        );
    }

    /**
     * @return void
     */
    public function testCreateNotClaimedErrorResponse(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->with(
                static::callback(
                    static function (RestErrorMessageTransfer $restErrorMessageTransfer) {
                        return $restErrorMessageTransfer->getStatus() === Response::HTTP_UNPROCESSABLE_ENTITY
                            && $restErrorMessageTransfer->getCode() === CollaborativeCartsRestApiConfig::RESPONSE_CODE_NOT_CLAIMED
                            && $restErrorMessageTransfer->getDetail() === CollaborativeCartsRestApiConfig::RESPONSE_DETAIL_NOT_CLAIMED;
                    },
                ),
            )
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->collaborativeCartRestResponseBuilder->createNotClaimedErrorResponse(),
        );
    }

    /**
     * @return void
     */
    public function testCreateNotReleasedErrorResponse(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->with(
                static::callback(
                    static function (RestErrorMessageTransfer $restErrorMessageTransfer) {
                        return $restErrorMessageTransfer->getStatus() === Response::HTTP_UNPROCESSABLE_ENTITY
                            && $restErrorMessageTransfer->getCode() === CollaborativeCartsRestApiConfig::RESPONSE_DETAIL_NOT_RELEASED
                            && $restErrorMessageTransfer->getDetail() === CollaborativeCartsRestApiConfig::RESPONSE_DETAIL_NOT_RELEASED;
                    },
                ),
            )
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->collaborativeCartRestResponseBuilder->createNotReleasedErrorResponse(),
        );
    }

    /**
     * @return void
     */
    public function testCreateRestResponse(): void
    {
        $this->restCollaborativeCartsResponseAttributesMapperMock->expects(static::atLeastOnce())
            ->method('fromQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->restCollaborativeCartsResponseAttributesTransferMock);

        $this->restCollaborativeCartsResponseAttributesTransferMock->expects(static::atLeastOnce())
            ->method('setAction')
            ->with(CollaborativeCartsRestApiConfig::ACTION_CLAIM)
            ->willReturn($this->restCollaborativeCartsResponseAttributesTransferMock);

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResource')
            ->with(
                CollaborativeCartsRestApiConfig::RESOURCE_COLLABORATIVE_CARTS,
                null,
                $this->restCollaborativeCartsResponseAttributesTransferMock,
            )->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('setPayload')
            ->with($this->restCollaborativeCartsResponseAttributesTransferMock)
            ->willReturn($this->restResourceMock);

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceMock)
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('setStatus')
            ->with(Response::HTTP_CREATED)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->collaborativeCartRestResponseBuilder->createRestResponse(
                CollaborativeCartsRestApiConfig::ACTION_CLAIM,
                $this->quoteTransferMock,
            ),
        );
    }
}
