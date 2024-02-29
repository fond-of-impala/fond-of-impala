<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Builder;

use Codeception\Test\Unit;
use FondOfImpala\Glue\ProductListsBulkRestApi\ProductListsBulkRestApiConfig;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;
use Generated\Shared\Transfer\RestProductListsBulkTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class RestResponseBuilderTest extends Unit
{
    protected MockObject|RestResourceBuilderInterface $restResourceBuilderMock;

    protected RestProductListsBulkResponseTransfer|MockObject $restProductListsBulkResponseTransferMock;

    protected MockObject|RestResponseInterface $restResponseMock;

    protected MockObject|RestResourceInterface $restResourceMock;

    protected RestResponseBuilder $restResponseBuilder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkResponseTransferMock = $this->getMockBuilder(RestProductListsBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseBuilder = new RestResponseBuilder($this->restResourceBuilderMock);
    }

    /**
     * @return void
     */
    public function testBuildByRestProductListsBulkResponse(): void
    {
        $data = [
            'is_successful' => true,
            'invalid_indexes' => [0, 5],
        ];

        $this->restProductListsBulkResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->restProductListsBulkResponseTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn($data);

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResource')
            ->with(
                ProductListsBulkRestApiConfig::RESOURCE_PRODUCT_LISTS_BULK,
                null,
                static::callback(
                    static fn (
                        RestProductListsBulkTransfer $restProductListsBulkTransfer
                    ): bool => $restProductListsBulkTransfer->getInvalidIndexes() === $data['invalid_indexes']
                ),
            )->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('setPayload')
            ->with(
                static::callback(
                    static fn (
                        RestProductListsBulkTransfer $restProductListsBulkTransfer
                    ): bool => $restProductListsBulkTransfer->getInvalidIndexes() === $data['invalid_indexes']
                ),
            )->willReturn($this->restResourceMock);

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('setStatus')
            ->with(Response::HTTP_CREATED)
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->restResponseBuilder->buildByRestProductListsBulkResponse(
                $this->restProductListsBulkResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testBuildByRestProductListsBulkResponseWithError(): void
    {
        $this->restProductListsBulkResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->restProductListsBulkResponseTransferMock->expects(static::never())
            ->method('toArray');

        $this->restResourceBuilderMock->expects(static::never())
            ->method('createRestResource');

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('setStatus')
            ->with(Response::HTTP_BAD_REQUEST)
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::never())
            ->method('addResource');

        static::assertEquals(
            $this->restResponseMock,
            $this->restResponseBuilder->buildByRestProductListsBulkResponse(
                $this->restProductListsBulkResponseTransferMock,
            ),
        );
    }
}
