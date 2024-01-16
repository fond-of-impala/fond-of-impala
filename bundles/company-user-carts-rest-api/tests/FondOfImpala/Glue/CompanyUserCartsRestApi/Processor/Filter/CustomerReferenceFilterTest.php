<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestUserTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CustomerReferenceFilterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface|mixed
     */
    protected $restRequestMock;

    /**
     * @var \Generated\Shared\Transfer\RestUserTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $restUserTransferMock;

    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Processor\Filter\CustomerReferenceFilter
     */
    protected $customerReferenceFilter;

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
