<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\RestFilterExpander;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\ErpOrderCancellationRestApiCommunicationFactory;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToCustomerFacadeInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerReferenceRestFilterToFilterMapperExpanderPluginTest extends Unit
{
    protected MockObject|ErpOrderCancellationRestApiToCustomerFacadeInterface $customerFacadeMock;

    protected MockObject|CustomerTransfer $customerTransferMock;

    protected MockObject|ErpOrderCancellationRestApiCommunicationFactory $factoryMock;

    protected MockObject|RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransferMock;

    protected MockObject|ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransferMock;

    protected CustomerReferenceRestFilterToFilterMapperExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerFacadeMock = $this
            ->getMockBuilder(ErpOrderCancellationRestApiToCustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this
            ->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this
            ->getMockBuilder(ErpOrderCancellationRestApiCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationFilterTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationFilterTransferMock = $this
            ->getMockBuilder(RestErpOrderCancellationFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CustomerReferenceRestFilterToFilterMapperExpanderPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $customerReference = 'customerReference';
        $idCustomer = 1;

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerFacade')
            ->willReturn($this->customerFacadeMock);

        $this->customerFacadeMock->expects(static::atLeastOnce())
            ->method('findByReference')
            ->with($customerReference)
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('setFkCustomer')
            ->with($idCustomer)
            ->willReturn($this->erpOrderCancellationFilterTransferMock);

        static::assertEquals(
            $this->erpOrderCancellationFilterTransferMock,
            $this->plugin->expand(
                $this->restErpOrderCancellationFilterTransferMock,
                $this->erpOrderCancellationFilterTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithNoCustomerReference(): void
    {
        $customerReference = null;

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        static::assertEquals(
            $this->erpOrderCancellationFilterTransferMock,
            $this->plugin->expand(
                $this->restErpOrderCancellationFilterTransferMock,
                $this->erpOrderCancellationFilterTransferMock,
            ),
        );
    }
}
