<?php

namespace FondOfImpala\Zed\CustomerCompanyUserConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerCompanyUserConnector\Business\Model\CompanyUserDeleterInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerCompanyUserConnectorFacadeTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerTransfer|MockObject $customerTransferMock;

    /**
     * @var \FondOfImpala\Zed\CustomerCompanyUserConnector\Business\Model\CompanyUserDeleterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserDeleterInterface|MockObject $companyUserDeleter;

    /**
     * @var (\FondOfImpala\Zed\CustomerCompanyUserConnector\Business\CustomerCompanyUserConnectorBusinessFactory&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerCompanyUserConnectorBusinessFactory|MockObject $factoryMock;

    /**
     * @var \FondOfImpala\Zed\CustomerCompanyUserConnector\Business\CustomerCompanyUserConnectorFacade
     */
    protected CustomerCompanyUserConnectorFacade $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserDeleter = $this->getMockBuilder(CompanyUserDeleterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(CustomerCompanyUserConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CustomerCompanyUserConnectorFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testDeleteCompanyUserForCustomer(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUserDeleter')
            ->willReturn($this->companyUserDeleter);

        $this->companyUserDeleter->expects(static::atLeastOnce())
            ->method('deleteCompanyUserForCustomer')
            ->with($this->customerTransferMock);

        $this->facade->deleteCompanyUserForCustomer($this->customerTransferMock);
    }
}
