<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Builder;

use Codeception\Test\Unit;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiConfig;
use Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class RestResponseBuilderTest extends Unit
{
    protected MockObject|RestResourceBuilderInterface $restResourceBuilderMock;

    protected RestOrderBudgetsBulkResponseTransfer|MockObject $restOrderBudgetsBulkResponseTransferMock;

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

        $this->restOrderBudgetsBulkResponseTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkResponseTransfer::class)
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
    public function testBuildRestResponseByRestOrderBudgetsBulkResponse(): void
    {
        $data = [
            'is_successful' => true,
            'invalid_indexes' => [0, 5],
        ];

        $this->restOrderBudgetsBulkResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->restOrderBudgetsBulkResponseTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn($data);

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResource')
            ->with(
                OrderBudgetsBulkRestApiConfig::RESOURCE_ORDER_BUDGETS_BULK,
                null,
                static::callback(
                    static fn (RestOrderBudgetsBulkTransfer $restOrderBudgetsBulkTransfer): bool => $restOrderBudgetsBulkTransfer->getInvalidIndexes() === $data['invalid_indexes']
                ),
            )->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('setPayload')
            ->with(
                static::callback(
                    static fn (RestOrderBudgetsBulkTransfer $restOrderBudgetsBulkTransfer): bool => $restOrderBudgetsBulkTransfer->getInvalidIndexes() === $data['invalid_indexes']
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
            $this->restResponseBuilder->buildRestResponseByRestOrderBudgetsBulkResponse(
                $this->restOrderBudgetsBulkResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testBuildRestResponseByRestOrderBudgetsBulkResponseWithError(): void
    {
        $this->restOrderBudgetsBulkResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->restOrderBudgetsBulkResponseTransferMock->expects(static::never())
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
            $this->restResponseBuilder->buildRestResponseByRestOrderBudgetsBulkResponse(
                $this->restOrderBudgetsBulkResponseTransferMock,
            ),
        );
    }
}
