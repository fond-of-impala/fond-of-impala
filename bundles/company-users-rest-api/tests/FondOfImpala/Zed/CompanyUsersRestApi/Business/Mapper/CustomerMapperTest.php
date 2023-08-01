<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;

class CustomerMapperTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CustomerMapper
     */
    protected $customerMapper;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCustomerFacadeInterface
     */
    protected $customerFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCustomerTransfer
     */
    protected $restCustomerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerFacadeInterfaceMock = $this->getMockBuilder(CompanyUsersRestApiToCustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerTransferMock = $this->getMockBuilder(RestCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerMapper = new CustomerMapper($this->customerFacadeInterfaceMock);
    }

    /**
     * @return void
     */
    public function testMapRestCustomerToCustomer(): void
    {
        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('fromArray')
            ->willReturn($this->customerTransferMock);

        static::assertEquals(
            $this->customerTransferMock,
            $this->customerMapper->mapRestCustomerTransferToCustomerTransfer(
                $this->restCustomerTransferMock,
                $this->customerTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testFromRestCustomer(): void
    {
        $data = [
            'firstName' => 'Foo',
        ];

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn($data);

        $customerTransfer = $this->customerMapper->fromRestCustomer($this->restCustomerTransferMock);

        static::assertEquals(
            $data['firstName'],
            $customerTransfer->getFirstName(),
        );
    }
}
