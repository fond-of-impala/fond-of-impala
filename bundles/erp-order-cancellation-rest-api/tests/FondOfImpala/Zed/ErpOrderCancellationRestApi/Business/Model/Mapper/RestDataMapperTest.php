<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Expander\ErpOrderCancellationExpanderInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestCancellationItemTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestDataMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer
     */
    protected MockObject|RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationTransfer
     */
    protected MockObject|RestErpOrderCancellationTransfer $restErpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCancellationItemTransfer
     */
    protected MockObject|RestCancellationItemTransfer $restCancellationItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer
     */
    protected MockObject|RestErpOrderCancellationAttributesTransfer $restErpOrderCancellationAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Expander\ErpOrderCancellationExpanderInterface
     */
    protected MockObject|ErpOrderCancellationExpanderInterface $erpOrderCancellationExpanderMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestDataMapper
     */
    protected RestDataMapper $mapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restErpOrderCancellationRequestTransferMock = $this->getMockBuilder(RestErpOrderCancellationRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationTransferMock = $this->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationTransferMock = $this->getMockBuilder(RestErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationAttributesTransferMock = $this->getMockBuilder(RestErpOrderCancellationAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCancellationItemTransferMock = $this->getMockBuilder(RestCancellationItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationExpanderMock = $this->getMockBuilder(ErpOrderCancellationExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mapper = new RestDataMapper($this->erpOrderCancellationExpanderMock);
    }

    /**
     * @return void
     */
    public function testMapResponse(): void
    {
        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerInternal')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->mapper->mapResponse($this->erpOrderCancellationTransferMock);
    }

    /**
     * @return void
     */
    public function testMapFromRequest(): void
    {
        $itemCollection = new ArrayObject([$this->restCancellationItemTransferMock]);

        $this->restErpOrderCancellationRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restErpOrderCancellationAttributesTransferMock);

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('modifiedToArray')
            ->willReturn([]);

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationItems')
            ->willReturn($itemCollection);

        $this->restCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('modifiedToArray')
            ->willReturn([]);

        $this->erpOrderCancellationExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->mapper->mapFromRequest($this->restErpOrderCancellationRequestTransferMock);
    }
}
