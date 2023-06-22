<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;

class CustomerReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model\CustomerReader
     */
    protected $customerReader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepositoryInterface
     */
    protected $conditionalAvailabilityCartConnectorRepositoryInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Facade\ConditionalAvailabilityCartConnectorToCustomerFacadeInterface
     */
    protected $customerFacadeInterfaceMock;

    /**
     * @var string
     */
    protected $customerReference;

    /**
     * @var int
     */
    protected $idCustomer;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityCartConnectorRepositoryInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerFacadeInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityCartConnectorToCustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerReference = 'customer-reference';

        $this->idCustomer = 1;

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerReader = new CustomerReader(
            $this->conditionalAvailabilityCartConnectorRepositoryInterfaceMock,
            $this->customerFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testGetCustomerByCustomerReference(): void
    {
        $this->conditionalAvailabilityCartConnectorRepositoryInterfaceMock->expects($this->atLeastOnce())
            ->method('getIdCustomerByCustomerReference')
            ->with($this->customerReference)
            ->willReturn($this->idCustomer);

        $this->customerFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->assertInstanceOf(
            CustomerTransfer::class,
            $this->customerReader->getCustomerByCustomerReference(
                $this->customerReference,
            ),
        );
    }
}
