<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter\RestCustomerFilterInterface;
use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class RestClaimCartRequestExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Filter\RestCustomerFilterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCustomerFilterMock;

    /**
     * @var \Generated\Shared\Transfer\RestClaimCartRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restClaimCartRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \Generated\Shared\Transfer\RestCustomerTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCustomerTransferMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\Expander\RestClaimCartRequestExpander
     */
    protected $restClaimCartRequestExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restCustomerFilterMock = $this->getMockBuilder(RestCustomerFilterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restClaimCartRequestTransferMock = $this->getMockBuilder(RestClaimCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerTransferMock = $this->getMockBuilder(RestCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restClaimCartRequestExpander = new RestClaimCartRequestExpander(
            $this->restCustomerFilterMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $customerReference = 'FOO--1';
        $idCustomer = '1';

        $this->restCustomerFilterMock->expects(static::atLeastOnce())
            ->method('fromRestRequest')
            ->with($this->restRequestMock)
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->restClaimCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('setNewCustomerReference')
            ->with($customerReference)
            ->willReturn($this->restClaimCartRequestTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->restClaimCartRequestTransferMock->expects(static::atLeastOnce())
            ->method('setNewIdCustomer')
            ->with($idCustomer)
            ->willReturn($this->restClaimCartRequestTransferMock);

        static::assertEquals(
            $this->restClaimCartRequestTransferMock,
            $this->restClaimCartRequestExpander->expand(
                $this->restClaimCartRequestTransferMock,
                $this->restRequestMock,
            ),
        );
    }
}
