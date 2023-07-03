<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Model\CompanyUserDeleterInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerAnonymizerCompanyUserConnectorFacadeTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerTransfer|MockObject $customerTransferMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Model\CompanyUserDeleterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserDeleterInterface|MockObject $companyUserDeleter;

    /**
     * @var (\FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\CustomerAnonymizerCompanyUserConnectorBusinessFactory&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerAnonymizerCompanyUserConnectorBusinessFactory|MockObject $factoryMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\CustomerAnonymizerCompanyUserConnectorFacade
     */
    protected CustomerAnonymizerCompanyUserConnectorFacade $facade;

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

        $this->factoryMock = $this->getMockBuilder(CustomerAnonymizerCompanyUserConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CustomerAnonymizerCompanyUserConnectorFacade();
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
            ->method('deleteByCustomer')
            ->with($this->customerTransferMock);

        $this->facade->deleteCompanyUsersForCustomer($this->customerTransferMock);
    }
}
