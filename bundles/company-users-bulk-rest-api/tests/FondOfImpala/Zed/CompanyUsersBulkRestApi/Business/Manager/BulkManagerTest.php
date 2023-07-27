<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Manager\BulkManager;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Permission\PermissionCheckerInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\PluginExecutioner\BulkDataPluginExecutionerInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepository;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkCompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkCompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkCompanyTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkCustomerTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer;
use Generated\Shared\Transfer\CompanyUsersBulkPreparationTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkItemTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;

class BulkManagerTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Permission\PermissionCheckerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected PermissionCheckerInterface|MockObject $permissionCheckerMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToEventFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiToEventFacadeInterface|MockObject $eventFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToCompanyUserFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiToCompanyUserFacadeInterface|MockObject $companyUserFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\PluginExecutioner\BulkDataPluginExecutionerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected BulkDataPluginExecutionerInterface|MockObject $pluginExecutionerMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Persistence\CompanyUsersBulkRestApiRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkRestApiRepositoryInterface|MockObject $repositoryMock;

    /**
     * @var \Psr\Log\LoggerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected LoggerInterface|MockObject $loggerMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkRequestTransfer|MockObject $restCompanyUsersBulkRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkResponseTransfer|MockObject $restCompanyUsersBulkResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkRequestAttributesTransfer|MockObject $restCompanyUsersBulkRequestAttributesTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkItemTransfer|MockObject $restCompanyUsersBulkItemTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUsersBulkItemCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUsersBulkItemCollectionTransfer|MockObject $restCompanyUsersBulkItemCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkPreparationCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkPreparationCollectionTransfer|MockObject $companyUsersBulkPreparationCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkPreparationTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkPreparationTransfer|MockObject $companyUsersBulkPreparationTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkCompanyTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkCompanyTransfer|MockObject $companyTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkCustomerTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkCustomerTransfer|MockObject $customerTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkCompanyRoleTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkCompanyRoleTransfer|MockObject $companyRoleTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUsersBulkCompanyBusinessUnitTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUsersBulkCompanyBusinessUnitTransfer|MockObject $companyBusinessUnitTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserResponseTransfer|MockObject $companyUserResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserCollectionTransfer|MockObject $companyUserCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserTransfer|MockObject $companyUserTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Business\Manager\BulkManager
     */
    protected BulkManager $bulkManager;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->permissionCheckerMock = $this
            ->getMockBuilder(PermissionCheckerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this
            ->getMockBuilder(CompanyUsersBulkRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventFacadeMock = $this
            ->getMockBuilder(CompanyUsersBulkRestApiToEventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this
            ->getMockBuilder(CompanyUsersBulkRestApiToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pluginExecutionerMock = $this
            ->getMockBuilder(BulkDataPluginExecutionerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->loggerMock = $this
            ->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkRequestTransferMock = $this
            ->getMockBuilder(RestCompanyUsersBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkResponseTransferMock = $this
            ->getMockBuilder(RestCompanyUsersBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkRequestAttributesTransferMock = $this
            ->getMockBuilder(RestCompanyUsersBulkRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkItemTransferMock = $this
            ->getMockBuilder(RestCompanyUsersBulkItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersBulkItemCollectionTransferMock = $this
            ->getMockBuilder(RestCompanyUsersBulkItemCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersBulkPreparationCollectionTransferMock = $this
            ->getMockBuilder(CompanyUsersBulkPreparationCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersBulkPreparationTransferMock = $this
            ->getMockBuilder(CompanyUsersBulkPreparationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this
            ->getMockBuilder(CompanyUsersBulkCompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this
            ->getMockBuilder(CompanyUsersBulkCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this
            ->getMockBuilder(CompanyUsersBulkCompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this
            ->getMockBuilder(CompanyUsersBulkCompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this
            ->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCollectionTransferMock = $this
            ->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this
            ->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bulkManager = new BulkManager(
            $this->permissionCheckerMock,
            $this->eventFacadeMock,
            $this->companyUserFacadeMock,
            $this->pluginExecutionerMock,
            $this->repositoryMock,
            $this->loggerMock,
        );
    }

    /**
     * @return void
     */
    public function testHandleBulkRequestMissingPermission(): void
    {
        $this->pluginExecutionerMock->expects(static::atLeastOnce())
            ->method('executePreHandlePlugins')
            ->willReturn($this->restCompanyUsersBulkRequestTransferMock);

        $this->pluginExecutionerMock->expects(static::atLeastOnce())
            ->method('executePostHandlePlugins')
            ->willReturn($this->restCompanyUsersBulkResponseTransferMock);

        $this->permissionCheckerMock->expects(static::atLeastOnce())
            ->method('check')
            ->willReturn(false);

        $this->eventFacadeMock->expects(static::never())
            ->method('trigger');

        $this->bulkManager->handleBulkRequest($this->restCompanyUsersBulkRequestTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleBulkRequest(): void
    {
        $ao = new ArrayObject();
        $ao->append($this->restCompanyUsersBulkItemTransferMock);

        $this->pluginExecutionerMock->expects(static::atLeastOnce())
            ->method('executePreHandlePlugins')
            ->willReturn($this->restCompanyUsersBulkRequestTransferMock);

        $this->pluginExecutionerMock->expects(static::atLeastOnce())
            ->method('executePostHandlePlugins')
            ->willReturn($this->restCompanyUsersBulkResponseTransferMock);

        $this->restCompanyUsersBulkRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restCompanyUsersBulkRequestAttributesTransferMock);

        $this->restCompanyUsersBulkRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getAssign')
            ->willReturn($ao);

        $this->restCompanyUsersBulkRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getUnassign')
            ->willReturn($ao);

        $this->permissionCheckerMock->expects(static::atLeastOnce())
            ->method('check')
            ->willReturn(true);

        $this->eventFacadeMock->expects(static::exactly(2))
            ->method('trigger');

        $this->bulkManager->handleBulkRequest($this->restCompanyUsersBulkRequestTransferMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyUser(): void
    {
        $role = 'distribution';
        $companyRoles = new ArrayObject();
        $companyRoles->append($this->companyRoleTransferMock);
        $preparationItems = new ArrayObject();
        $preparationItems->append($this->companyUsersBulkPreparationTransferMock);
        $bulkItems = new ArrayObject();
        $bulkItems->append($this->restCompanyUsersBulkItemTransferMock);
        $companyBusinessUnits = new ArrayObject();
        $companyBusinessUnits->append($this->companyBusinessUnitTransferMock);

        $this->restCompanyUsersBulkItemCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($bulkItems);

        $this->pluginExecutionerMock
            ->expects(static::atLeastOnce())
            ->method('executeExpand')
            ->willReturn($this->companyUsersBulkPreparationCollectionTransferMock);

        $this->companyUsersBulkPreparationCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($preparationItems);

        $this->companyUsersBulkPreparationTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyOrFail')
            ->willReturn($this->companyTransferMock);

        $this->companyUsersBulkPreparationTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCustomerOrFail')
            ->willReturn($this->customerTransferMock);

        $this->companyUsersBulkPreparationTransferMock
            ->expects(static::atLeastOnce())
            ->method('getItem')
            ->willReturn($this->restCompanyUsersBulkItemTransferMock);

        $this->restCompanyUsersBulkItemTransferMock
            ->expects(static::atLeastOnce())
            ->method('getRole')
            ->willReturn($role);

        $this->companyTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyRoles')
            ->willReturn($companyRoles);

        $this->companyTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyBusinessUnits')
            ->willReturn($companyBusinessUnits);

        $this->companyBusinessUnitTransferMock
            ->expects(static::atLeastOnce())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn(1);

        $this->companyRoleTransferMock
            ->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($role);

        $this->customerTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn('custref');

        $this->customerTransferMock
            ->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(2);

        $this->companyTransferMock
            ->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn(3);

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('isCompanyUserAlreadyAvailable')
            ->willReturn(false);

        $this->companyUserFacadeMock
            ->expects(static::atLeastOnce())
            ->method('create')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock
            ->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->bulkManager->createCompanyUser($this->restCompanyUsersBulkItemCollectionTransferMock);
    }

    /**
     * @return void
     */
    public function testDeleteCompanyUser(): void
    {
        $role = 'distribution';
        $companyRoles = new ArrayObject();
        $companyRoles->append($this->companyRoleTransferMock);
        $preparationItems = new ArrayObject();
        $preparationItems->append($this->companyUsersBulkPreparationTransferMock);
        $bulkItems = new ArrayObject();
        $bulkItems->append($this->restCompanyUsersBulkItemTransferMock);
        $companyBusinessUnits = new ArrayObject();
        $companyBusinessUnits->append($this->companyBusinessUnitTransferMock);
        $companyUserCollection = new ArrayObject();
        $companyUserCollection->append($this->companyUserTransferMock);

        $this->restCompanyUsersBulkItemCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($bulkItems);

        $this->pluginExecutionerMock
            ->expects(static::atLeastOnce())
            ->method('executeExpand')
            ->willReturn($this->companyUsersBulkPreparationCollectionTransferMock);

        $this->companyUsersBulkPreparationCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getItems')
            ->willReturn($preparationItems);

        $this->companyUsersBulkPreparationTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyOrFail')
            ->willReturn($this->companyTransferMock);

        $this->companyUsersBulkPreparationTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCustomerOrFail')
            ->willReturn($this->customerTransferMock);

        $this->companyUsersBulkPreparationTransferMock
            ->expects(static::atLeastOnce())
            ->method('getItem')
            ->willReturn($this->restCompanyUsersBulkItemTransferMock);

        $this->restCompanyUsersBulkItemTransferMock
            ->expects(static::atLeastOnce())
            ->method('getRole')
            ->willReturn($role);

        $this->companyRoleTransferMock
            ->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($role);

        $this->customerTransferMock
            ->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(2);

        $this->companyTransferMock
            ->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn(3);

        $this->repositoryMock
            ->expects(static::atLeastOnce())
            ->method('findCompanyUsersByFkCompanyAndFkCustomer')
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn($companyUserCollection);

        $this->companyUserTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyRole')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyUserFacadeMock
            ->expects(static::atLeastOnce())
            ->method('deleteCompanyUser')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock
            ->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->bulkManager->deleteCompanyUser($this->restCompanyUsersBulkItemCollectionTransferMock);
    }
}
