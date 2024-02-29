<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Processor\ProductListsBulk;

use Codeception\Test\Unit;
use FondOfImpala\Client\ProductListsBulkRestApi\ProductListsBulkRestApiClientInterface;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Builder\RestResponseBuilderInterface;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Filter\CustomerReferenceFilterInterface;
use FondOfImpala\Glue\ProductListsBulkRestApi\Processor\Mapper\RestProductListsBulkRequestMapperInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class ProductListsBulkProcessorTest extends Unit
{
    protected MockObject|CustomerReferenceFilterInterface $customerReferenceFilterMock;

    protected RestProductListsBulkRequestMapperInterface|MockObject $restProductListsBulkRequestMapperMock;

    protected MockObject|RestResponseBuilderInterface $restResponseBuilderMock;

    protected MockObject|ProductListsBulkRestApiClientInterface $clientMock;

    protected RestRequestInterface|MockObject $restRequestMock;

    protected RestProductListsBulkRequestAttributesTransfer|MockObject $restProductListsBulkRequestAttributesTransferMock;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    protected RestProductListsBulkResponseTransfer|MockObject $restProductListsBulkResponseTransferMock;

    protected RestResponseInterface|MockObject $restResponseMock;

    protected ProductListsBulkProcessor $ProductListsBulkProcessor;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerReferenceFilterMock = $this->getMockBuilder(CustomerReferenceFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestMapperMock = $this->getMockBuilder(RestProductListsBulkRequestMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseBuilderMock = $this->getMockBuilder(RestResponseBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(ProductListsBulkRestApiClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestAttributesTransferMock = $this->getMockBuilder(RestProductListsBulkRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestTransferMock = $this->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkResponseTransferMock = $this->getMockBuilder(RestProductListsBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->ProductListsBulkProcessor = new ProductListsBulkProcessor(
            $this->customerReferenceFilterMock,
            $this->restProductListsBulkRequestMapperMock,
            $this->restResponseBuilderMock,
            $this->clientMock,
        );
    }

    /**
     * @return void
     */
    public function testProcess(): void
    {
        $customerReference = 'customer-reference';

        $this->customerReferenceFilterMock->expects(static::atLeastOnce())
            ->method('filterFromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($customerReference);

        $this->restProductListsBulkRequestMapperMock->expects(static::atLeastOnce())
            ->method('fromRestProductListsBulkRequestAttributes')
            ->with($this->restProductListsBulkRequestAttributesTransferMock)
            ->willReturn($this->restProductListsBulkRequestTransferMock);

        $this->restProductListsBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('setCustomerReference')
            ->with($customerReference)
            ->willReturn($this->restProductListsBulkRequestTransferMock);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('bulkProcess')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($this->restProductListsBulkResponseTransferMock);

        $this->restResponseBuilderMock->expects(static::atLeastOnce())
            ->method('buildByRestProductListsBulkResponse')
            ->with($this->restProductListsBulkResponseTransferMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->ProductListsBulkProcessor->process(
                $this->restRequestMock,
                $this->restProductListsBulkRequestAttributesTransferMock,
            ),
        );
    }
}
