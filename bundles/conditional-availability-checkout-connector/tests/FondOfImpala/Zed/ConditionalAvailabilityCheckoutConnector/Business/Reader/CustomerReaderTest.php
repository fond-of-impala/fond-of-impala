<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Reader;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToCustomerFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Persistence\ConditionalAvailabilityCheckoutConnectorRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerReaderTest extends Unit
{
    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToCustomerFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCheckoutConnectorToCustomerFacadeInterface|MockObject $customerFacadeMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Persistence\ConditionalAvailabilityCheckoutConnectorRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityCheckoutConnectorRepositoryInterface|MockObject $repositoryMock;

    /**
     * @var (\Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CustomerTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerTransfer|MockObject $customerTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Reader\CustomerReader
     */
    protected CustomerReader $customerReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerFacadeMock = $this->getMockBuilder(ConditionalAvailabilityCheckoutConnectorToCustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ConditionalAvailabilityCheckoutConnectorRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerReader = new CustomerReader(
            $this->customerFacadeMock,
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testGetByQuote(): void
    {
        $customerReference = 'FOO';
        $idCustomer = 1;

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getIdCustomerByCustomerReference')
            ->with($customerReference)
            ->willReturn($idCustomer);

        $this->customerFacadeMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->with(
                static::callback(
                    static fn (
                        CustomerTransfer $customerTransfer
                    ): bool => $customerTransfer->getIdCustomer() === $idCustomer
                ),
            )->willReturn($this->customerTransferMock);

        static::assertEquals(
            $this->customerTransferMock,
            $this->customerReader->getByQuote($this->quoteTransferMock),
        );
    }
}
