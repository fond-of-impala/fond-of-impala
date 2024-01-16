<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestUserTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class RestCustomerFilterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \Generated\Shared\Transfer\RestUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restUserTransferMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter\RestCustomerFilter
     */
    protected $restCustomerFilter;

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

        $this->restCustomerFilter = new RestCustomerFilter();
    }

    /**
     * @return void
     */
    public function testFromRestRequest(): void
    {
        $customerReference = 'FOO--1';
        $idCustomer = 1;

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects(static::atLeastOnce())
            ->method('getNaturalIdentifier')
            ->willReturn($customerReference);

        $this->restUserTransferMock->expects(static::atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($idCustomer);

        $restCustomerTransfer = $this->restCustomerFilter->fromRestRequest($this->restRequestMock);

        static::assertEquals(
            $customerReference,
            $restCustomerTransfer->getCustomerReference(),
        );

        static::assertEquals(
            $idCustomer,
            $restCustomerTransfer->getIdCustomer(),
        );
    }

    /**
     * @return void
     */
    public function testFromRestRequestWithoutRestUser(): void
    {
        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getRestUser')
            ->willReturn(null);

        $restCustomerTransfer = $this->restCustomerFilter->fromRestRequest($this->restRequestMock);

        static::assertEquals(
            null,
            $restCustomerTransfer->getCustomerReference(),
        );

        static::assertEquals(
            null,
            $restCustomerTransfer->getIdCustomer(),
        );
    }
}
