<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Client\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiClientInterface;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Filter\CustomerReferenceFilterInterface;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper\RestOrderBudgetsBulkRequestMapperInterface;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\OrderBudgetsBulk\OrderBudgetsBulkProcessor;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class OrderBudgetsBulkProcessorTest extends Unit
{
    protected MockObject|CustomerReferenceFilterInterface $customerReferenceFilterMock;

    protected RestOrderBudgetsBulkRequestMapperInterface|MockObject $restOrderBudgetsBulkRequestMapperMock;

    protected MockObject|RestResponseBuilderInterface $restResponseBuilderMock;

    protected MockObject|OrderBudgetsBulkRestApiClientInterface $clientMock;

    protected RestRequestInterface|MockObject $restRequestMock;

    protected RestOrderBudgetsBulkRequestAttributesTransfer|MockObject $restOrderBudgetsBulkRequestAttributesTransferMock;

    protected MockObject|RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransferMock;

    protected RestOrderBudgetsBulkResponseTransfer|MockObject $restOrderBudgetsBulkResponseTransferMock;

    protected RestResponseInterface|MockObject $restResponseMock;

    protected OrderBudgetsBulkProcessor $orderBudgetsBulkProcessor;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerReferenceFilterMock = $this->getMockBuilder(CustomerReferenceFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestMapperMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseBuilderMock = $this->getMockBuilder(RestResponseBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(OrderBudgetsBulkRestApiClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestAttributesTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkResponseTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderBudgetsBulkProcessor = new OrderBudgetsBulkProcessor(
            $this->customerReferenceFilterMock,
            $this->restOrderBudgetsBulkRequestMapperMock,
            $this->restResponseBuilderMock,
            $this->clientMock,
        );
    }

    /**
     * @return void
     */
    public function testProcess(): void
    {
        $customerReference = 'FOO-C--1';

        $this->customerReferenceFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($customerReference);

        $this->restOrderBudgetsBulkRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestOrderBudgetsBulkRequestAttributes')
            ->with($this->restOrderBudgetsBulkRequestAttributesTransferMock)
            ->willReturn($this->restOrderBudgetsBulkRequestTransferMock);

        $this->restOrderBudgetsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('setCustomerReference')
            ->with($customerReference)
            ->willReturn($this->restOrderBudgetsBulkRequestTransferMock);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('bulkProcess')
            ->with($this->restOrderBudgetsBulkRequestTransferMock)
            ->willReturn($this->restOrderBudgetsBulkResponseTransferMock);

        $this->restResponseBuilderMock->expects(static::atLeastOnce())
            ->method('buildRestResponseByRestOrderBudgetsBulkResponse')
            ->with($this->restOrderBudgetsBulkResponseTransferMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->orderBudgetsBulkProcessor->process(
                $this->restRequestMock,
                $this->restOrderBudgetsBulkRequestAttributesTransferMock,
            ),
        );
    }
}
