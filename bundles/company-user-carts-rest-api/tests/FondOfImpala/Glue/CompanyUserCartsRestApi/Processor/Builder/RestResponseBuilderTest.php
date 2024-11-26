<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsAttributesMapperInterface;
use FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestItemsAttributesMapperInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteErrorTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsAttributesTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Generated\Shared\Transfer\RestItemsAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestLinkInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Symfony\Component\HttpFoundation\Response;

class RestResponseBuilderTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestCartsAttributesMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCartsAttributesMapperMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Mapper\RestItemsAttributesMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restItemsAttributesMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteErrorTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteErrorTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $relatedRestResourceMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCartsAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCartsAttributesTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $itemTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestItemsAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restItemsAttributesTransferMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Builder\RestResponseBuilder
     */
    protected $restResponseBuilder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restCartsAttributesMapperMock = $this->getMockBuilder(RestCartsAttributesMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restItemsAttributesMapperMock = $this->getMockBuilder(RestItemsAttributesMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteErrorTransferMock = $this->getMockBuilder(QuoteErrorTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->relatedRestResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartsAttributesTransferMock = $this->getMockBuilder(RestCartsAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restItemsAttributesTransferMock = $this->getMockBuilder(RestItemsAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseBuilder = new RestResponseBuilder(
            $this->restCartsAttributesMapperMock,
            $this->restItemsAttributesMapperMock,
            $this->restResourceBuilderMock,
        );
    }

    /**
     * @return void
     */
    public function testBuildErrorRestResponse(): void
    {
        $message = 'foo';

        $quoteErrorTransferMocks = [
            $this->quoteErrorTransferMock,
        ];

        $this->quoteErrorTransferMock->expects(static::atLeastOnce())
            ->method('getMessage')
            ->willReturn($message);

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->with(
                static::callback(
                    static function (RestErrorMessageTransfer $restErrorMessageTransfer) use ($message) {
                        return $restErrorMessageTransfer->getDetail() === $message
                            && $restErrorMessageTransfer->getCode() === CompanyUserCartsRestApiConfig::RESPONSE_CODE_OTHER
                            && $restErrorMessageTransfer->getStatus() === Response::HTTP_BAD_REQUEST;
                    },
                ),
            )->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->restResponseBuilder->buildErrorRestResponse($quoteErrorTransferMocks),
        );
    }

    /**
     * @return void
     */
    public function testBuildErrorRestResponseWithoutMessage(): void
    {
        $quoteErrorTransferMocks = [];

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->with(
                static::callback(
                    static function (RestErrorMessageTransfer $restErrorMessageTransfer) {
                        return $restErrorMessageTransfer->getDetail() === 'Undefined'
                            && $restErrorMessageTransfer->getCode() === CompanyUserCartsRestApiConfig::RESPONSE_CODE_OTHER
                            && $restErrorMessageTransfer->getStatus() === Response::HTTP_BAD_REQUEST;
                    },
                ),
            )->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->restResponseBuilder->buildErrorRestResponse($quoteErrorTransferMocks),
        );
    }

    /**
     * @return void
     */
    public function testBuildRestResponse(): void
    {
        $self = $this;

        $uuid = 'e6b02939-18fc-4857-837e-f0e8063c306e';
        $groupKey = 'foo.bar-1';
        $companyUserReference = 'FOO--CU-1';

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn($uuid);

        $this->restCartsAttributesMapperMock->expects(static::atLeastOnce())
            ->method('fromQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->restCartsAttributesTransferMock);

        $callCount = $this->atLeastOnce();
        $this->restResourceBuilderMock->expects($callCount)
            ->method('createRestResource')
            ->willReturnCallback(static function (string $type, ?string $id = null, ?AbstractTransfer $attributeTransfer = null) use ($self, $callCount, $uuid, $groupKey) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        $self->assertSame(CompanyUserCartsRestApiConfig::RESOURCE_COMPANY_USER_CARTS, $type);
                        $self->assertSame($uuid, $id);
                        $self->assertSame($self->restCartsAttributesTransferMock, $attributeTransfer);

                        return $self->restResourceMock;
                    case 2:
                        $self->assertSame(CompanyUserCartsRestApiConfig::RESOURCE_CART_ITEMS, $type);
                        $self->assertSame($groupKey, $id);
                        $self->assertSame($self->restItemsAttributesTransferMock, $attributeTransfer);

                        return $self->relatedRestResourceMock;
                }

                throw new Exception('Unexpected call count');
            });

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('setPayload')
            ->with($this->quoteTransferMock)
            ->willReturn($this->restResourceMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([$this->itemTransferMock]));

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getGroupKey')
            ->willReturn($groupKey);

        $this->restItemsAttributesMapperMock->expects(static::atLeastOnce())
            ->method('fromItem')
            ->with($this->itemTransferMock)
            ->willReturn($this->restItemsAttributesTransferMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($uuid);

        $this->relatedRestResourceMock->expects(static::atLeastOnce())
            ->method('addLink')
            ->with(
                RestLinkInterface::LINK_SELF,
                sprintf(
                    '%s/%s/%s/%s',
                    CompanyUserCartsRestApiConfig::RESOURCE_CARTS,
                    $uuid,
                    CompanyUserCartsRestApiConfig::RESOURCE_CART_ITEMS,
                    $groupKey,
                ),
            )->willReturn($this->relatedRestResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('addRelationship')
            ->with($this->relatedRestResourceMock)
            ->willReturn($this->restResourceMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('addLink')
            ->with(
                RestLinkInterface::LINK_SELF,
                sprintf(
                    CompanyUserCartsRestApiConfig::FORMAT_SELF_LINK_CART_RESOURCE,
                    CompanyUserCartsRestApiConfig::RESOURCE_COMPANY_USERS,
                    $companyUserReference,
                    CompanyUserCartsRestApiConfig::RESOURCE_COMPANY_USER_CARTS,
                    $uuid,
                ),
            )->willReturn($this->restResourceMock);

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->restResponseBuilder->buildRestResponse($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testBuildEmptyRestResponse(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->restResponseBuilder->buildEmptyRestResponse(),
        );
    }

    /**
     * @return void
     */
    public function testBuildCartIdIsMissingRestResponse(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->with(
                static::callback(
                    static function (RestErrorMessageTransfer $restErrorMessageTransfer) {
                        return $restErrorMessageTransfer->getDetail() === CompanyUserCartsRestApiConfig::RESPONSE_DETAIL_CART_ID_IS_MISSING
                            && $restErrorMessageTransfer->getCode() === CompanyUserCartsRestApiConfig::RESPONSE_CODE_CART_ID_IS_MISSING
                            && $restErrorMessageTransfer->getStatus() === Response::HTTP_BAD_REQUEST;
                    },
                ),
            )->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->restResponseBuilder->buildCartIdIsMissingRestResponse(),
        );
    }
}
