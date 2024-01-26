<?php

namespace FondOfImpala\Zed\CollaborativeCart\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;

class CollaborativeCartToCustomerFacadeBridgeTest extends Unit
{
    protected MockObject|CustomerFacadeInterface $customerFacadeMock;

    /**
     * @var string
     */
    protected $customerReference;

    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCustomerFacadeBridge
     */
    protected $collaborativeCartToCustomerFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->customerFacadeMock = $this->getMockBuilder(CustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerReference = 'DE-1';

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartToCustomerFacadeBridge = new CollaborativeCartToCustomerFacadeBridge(
            $this->customerFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindByReference(): void
    {
        $this->customerFacadeMock->expects(self::atLeastOnce())
            ->method('findByReference')
            ->with($this->customerReference)
            ->willReturn($this->customerTransferMock);

        self::assertEquals(
            $this->customerTransferMock,
            $this->collaborativeCartToCustomerFacadeBridge
                ->findByReference($this->customerReference),
        );
    }
}
