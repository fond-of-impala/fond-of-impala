<?php

namespace FondOfImpala\Zed\CustomerCompanyUserConnector\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerCompanyUserConnector\Dependency\Facade\CustomerCompanyUserConnectorToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CustomerCompanyUserConnector\Persistence\CustomerCompanyUserConnectorRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUserDeleterTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CustomerCompanyUserConnector\Persistence\CustomerCompanyUserConnectorRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerCompanyUserConnectorRepositoryInterface|MockObject $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\CustomerCompanyUserConnector\Dependency\Facade\CustomerCompanyUserConnectorToCompanyUserFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerCompanyUserConnectorToCompanyUserFacadeInterface|MockObject $companyUserFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerTransfer|MockObject $customerTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserCollectionTransfer|MockObject $companyUserCollectionTransfer;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserTransfer|MockObject $companyUserTransfer;

    /**
     * @var \FondOfImpala\Zed\CustomerCompanyUserConnector\Business\Model\CompanyUserDeleter
     */
    protected CompanyUserDeleter $companyUserDeleter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserFacadeMock = $this->getMockBuilder(CustomerCompanyUserConnectorToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CustomerCompanyUserConnectorRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransfer = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransfer = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserDeleter = new CompanyUserDeleter($this->companyUserFacadeMock, $this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testDeleteCompanyUserForCustomer(): void
    {
        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findCompanyUsersByFkCustomer')
            ->willReturn($this->companyUserCollectionTransfer);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomerOrFail')
            ->willReturn(1);

        $this->companyUserCollectionTransfer->expects(static::atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn(new ArrayObject([$this->companyUserTransfer]));

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('deleteCompanyUser')
            ->with($this->companyUserTransfer);

        $this->companyUserDeleter->deleteCompanyUserForCustomer(
            $this->customerTransferMock,
        );
    }
}
