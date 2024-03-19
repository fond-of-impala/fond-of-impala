<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Deleter;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Shared\CustomerAnonymizerCompanyUserConnector\CustomerAnonymizerCompanyUserConnectorConstants;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToEventFacadeInterface;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
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
     * @var (\Generated\Shared\Transfer\CompanyUserCollectionTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyUserCollectionTransfer $companyUserCollectionTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CompanyUserTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserTransfer|MockObject $companyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Deleter\CompanyUserDeleter
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

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
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
        $idCustomer = 1;
        $companyUserIds = [1, 2, 3];

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findCompanyUserIdsByFkCustomer')
            ->with($idCustomer)
            ->willReturn($this->companyUserIdCollectionTransferMock);

        $this->companyUserIdCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserIds')
            ->willReturn($companyUserIds);

        $this->eventFacadeMock->expects(static::atLeastOnce())
            ->method('trigger')
            ->with(
                CustomerAnonymizerCompanyUserConnectorConstants::EVENT_DELETE_COMPANY_USER,
                $this->companyUserIdCollectionTransferMock,
            );

        $this->companyUserDeleter->deleteByCustomer(
            $this->customerTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testDeleteCompanyUserByCompanyUserIdCollection(): void
    {
        $companyUserIds = [2];

        $this->companyUserIdCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserIds')
            ->willReturn($companyUserIds);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findCompanyUsersByIds')
            ->with(
                static::callback(
                    static fn (
                        CompanyUserCriteriaFilterTransfer $companyUserCriteriaFilterTransfer
                    ): bool => $companyUserCriteriaFilterTransfer->getCompanyUserIds() === $companyUserIds,
                ),
            )->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn(new ArrayObject([$this->companyUserTransferMock]));

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('deleteCompanyUser')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserDeleter->deleteCompanyUserByCompanyUserIdCollection(
            $this->companyUserIdCollectionTransferMock,
        );
    }
}
