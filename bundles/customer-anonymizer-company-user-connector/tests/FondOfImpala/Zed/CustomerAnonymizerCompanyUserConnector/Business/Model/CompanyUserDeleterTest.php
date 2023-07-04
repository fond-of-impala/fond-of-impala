<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserIdCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUserDeleterTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerAnonymizerCompanyUserConnectorRepositoryInterface|MockObject $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface|MockObject $companyUserFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface|MockObject $eventFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerTransfer|MockObject $customerTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserResponseTransfer|MockObject $companyUserResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserIdCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserIdCollectionTransfer|MockObject $companyUserIdCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Model\CompanyUserDeleter
     */
    protected CompanyUserDeleter $companyUserDeleter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserFacadeMock = $this->getMockBuilder(CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventFacadeMock = $this->getMockBuilder(CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CustomerAnonymizerCompanyUserConnectorRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserIdCollectionTransferMock = $this->getMockBuilder(CompanyUserIdCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserDeleter = new CompanyUserDeleter(
            $this->companyUserFacadeMock,
            $this->eventFacadeMock,
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testDeleteByCustomer(): void
    {
        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findCompanyUserIdsByFkCustomer')
            ->willReturn($this->companyUserIdCollectionTransferMock);

        $this->companyUserIdCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getIds')
            ->willReturn([100]);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomerOrFail')
            ->willReturn(1);

        $this->eventFacadeMock->expects(static::atLeastOnce())
            ->method('trigger');

        $this->companyUserDeleter->deleteByCustomer(
            $this->customerTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testDeleteCompanyUserByIds(): void
    {
        $self = $this;
        $this->companyUserIdCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getIds')
            ->willReturn([100]);

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('deleteCompanyUser')
            ->willReturnCallback(static function (CompanyUserTransfer $companyUserTransfer) use ($self) {
                $self->assertSame($companyUserTransfer->getIdCompanyUser(), 100);

                return $self->companyUserResponseTransferMock;
            });

        $this->companyUserDeleter->deleteCompanyUserByIds(
            $this->companyUserIdCollectionTransferMock,
        );
    }
}
