<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;

class ErpOrderCancellationRestApiToCustomerFacadeBridgeTest extends Unit
{
    protected ErpOrderCancellationRestApiToCustomerFacadeBridge $bridge;

    protected MockObject|CustomerFacadeInterface $customerFacadeMock;

    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerFacadeMock = $this
            ->getMockBuilder(CustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this
            ->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ErpOrderCancellationRestApiToCustomerFacadeBridge(
            $this->customerFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindByReference(): void
    {
        $reference = 'reference';

        $this->customerFacadeMock->expects(static::atLeastOnce())
            ->method('findByReference')
            ->with($reference)
            ->willReturn($this->customerTransferMock);

        $customerTransfer = $this->bridge->findByReference($reference);

        static::assertEquals($this->customerTransferMock, $customerTransfer);
    }
}
