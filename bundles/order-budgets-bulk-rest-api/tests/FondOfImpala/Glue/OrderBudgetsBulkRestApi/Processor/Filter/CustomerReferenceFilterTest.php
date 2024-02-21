<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Filter;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestUserTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CustomerReferenceFilterTest extends Unit
{
    protected RestRequestInterface|MockObject $restRequestMock;

    protected MockObject|RestUserTransfer $restUserTransferMock;

    protected CustomerReferenceFilter $customerReferenceFilter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restUserTransferMock = $this->getMockBuilder(RestUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerReferenceFilter = new CustomerReferenceFilter();
    }

    /**
     * @return void
     */
    public function testFilterFromRestRequest(): void
    {
        $customerReference = 'FOO-C--1';

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects(static::atLeastOnce())
            ->method('getNaturalIdentifier')
            ->willReturn($customerReference);

        static::assertEquals(
            $customerReference,
            $this->customerReferenceFilter->filterFromRestRequest($this->restRequestMock),
        );
    }
}
