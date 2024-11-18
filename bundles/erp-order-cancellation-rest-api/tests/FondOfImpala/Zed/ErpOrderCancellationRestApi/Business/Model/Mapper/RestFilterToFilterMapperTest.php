<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterPageTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterSortTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestFilterToFilterMapperTest extends Unit
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCustomerTransfer
     */
    protected MockObject|RestCustomerTransfer $restCustomerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer
     */
    protected MockObject|ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationFilterSortTransfer
     */
    protected MockObject|RestErpOrderCancellationFilterSortTransfer $restErpOrderCancellationFilterSortTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationFilterPageTransfer
     */
    protected MockObject|RestErpOrderCancellationFilterPageTransfer $restErpOrderCancellationFilterPageTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer
     */
    protected MockObject|RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer
     */
    protected MockObject|RestErpOrderCancellationAttributesTransfer $restErpOrderCancellationAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface
     */
    protected MockObject|ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface $erpOrderCancellationRestFilterToFilterMapperExpanderPluginMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestFilterToFilterMapper
     */
    protected RestFilterToFilterMapper $mapper;

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

        $this->restErpOrderCancellationFilterTransferMock = $this->getMockBuilder(RestErpOrderCancellationFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationFilterPageTransferMock = $this->getMockBuilder(RestErpOrderCancellationFilterPageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationFilterSortTransferMock = $this->getMockBuilder(RestErpOrderCancellationFilterSortTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationFilterTransferMock = $this->getMockBuilder(ErpOrderCancellationFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerTransferMock = $this->getMockBuilder(RestCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationRestFilterToFilterMapperExpanderPluginMock = $this->getMockBuilder(ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $plugins = [
            $this->erpOrderCancellationRestFilterToFilterMapperExpanderPluginMock,
        ];

        $this->mapper = new RestFilterToFilterMapper($plugins);
    }

    /**
     * @return void
     */
    public function testFromRestRequest(): void
    {
        $sorting = new ArrayObject();
        $sorting->append($this->restErpOrderCancellationFilterSortTransferMock);

        $this->restErpOrderCancellationRequestTransferMock->expects(static::atLeastOnce())
            ->method('getFilter')
            ->willReturn($this->restErpOrderCancellationFilterTransferMock);

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->erpOrderCancellationRestFilterToFilterMapperExpanderPluginMock->expects(static::atLeastOnce())
            ->method('expand')
            ->willReturn($this->erpOrderCancellationFilterTransferMock);

        $this->restErpOrderCancellationRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restErpOrderCancellationAttributesTransferMock);

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn('uuid');

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getOriginatorReference')
            ->willReturn('ref');

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getOriginator')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getPage')
            ->willReturn($this->restErpOrderCancellationFilterPageTransferMock);

        $this->restErpOrderCancellationFilterPageTransferMock->expects(static::atLeastOnce())
            ->method('getLimit')
            ->willReturn(10);

        $this->restErpOrderCancellationFilterPageTransferMock->expects(static::atLeastOnce())
            ->method('getOffset')
            ->willReturn(0);

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getSort')
            ->willReturn($sorting);

        $this->restErpOrderCancellationFilterSortTransferMock->expects(static::atLeastOnce())
            ->method('getField')
            ->willReturn('cancellation-number');

        $this->restErpOrderCancellationFilterSortTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->mapper->fromRestRequest($this->restErpOrderCancellationRequestTransferMock);
    }
}
