<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Shared\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiConstants;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestDataMapperInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestFilterToFilterMapperInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Permission\PermissionCheckerInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiRepository;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationPaginationTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\ErpOrderTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;

class CancellationManagerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Psr\Log\LoggerInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|LoggerInterface $loggerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiRepository
     */
    protected MockObject|ErpOrderCancellationRestApiRepository $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface
     */
    protected MockObject|ErpOrderCancellationRestApiToErpOrderFacadeInterface $erpOrderFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface
     */
    protected MockObject|ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface $erpOrderCancellationFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Permission\PermissionCheckerInterface
     */
    protected MockObject|PermissionCheckerInterface $permissionCheckerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestDataMapperInterface
     */
    protected MockObject|RestDataMapperInterface $restDataMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestFilterToFilterMapperInterface
     */
    protected MockObject|RestFilterToFilterMapperInterface $restFilterToFilterMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer
     */
    protected MockObject|RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    protected MockObject|ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationAttributesTransfer
     */
    protected MockObject|RestErpOrderCancellationAttributesTransfer $restErpOrderCancellationAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCustomerTransfer
     */
    protected MockObject|RestCustomerTransfer $restCustomerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected MockObject|CompanyUserTransfer $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderTransfer
     */
    protected MockObject|ErpOrderTransfer $erpOrderTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationTransfer
     */
    protected MockObject|RestErpOrderCancellationTransfer $restErpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    protected MockObject|ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer
     */
    protected MockObject|ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer
     */
    protected MockObject|ErpOrderCancellationCollectionTransfer $erpOrderCancellationCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationPaginationTransfer
     */
    protected MockObject|ErpOrderCancellationPaginationTransfer $erpOrderCancellationPaginationTransfer;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\CancellationManager
     */
    protected CancellationManager $cancellationManager;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ErpOrderCancellationRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderFacadeMock = $this->getMockBuilder(ErpOrderCancellationRestApiToErpOrderFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationFacadeMock = $this->getMockBuilder(ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionCheckerMock = $this->getMockBuilder(PermissionCheckerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restDataMapperMock = $this->getMockBuilder(RestDataMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restFilterToFilterMapperMock = $this->getMockBuilder(RestFilterToFilterMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationRequestTransferMock = $this->getMockBuilder(RestErpOrderCancellationRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationResponseTransferMock = $this->getMockBuilder(ErpOrderCancellationResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationAttributesTransferMock = $this->getMockBuilder(RestErpOrderCancellationAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationTransferMock = $this->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerTransferMock = $this->getMockBuilder(RestCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderTransferMock = $this->getMockBuilder(ErpOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationTransferMock = $this->getMockBuilder(RestErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationItemTransferMock = $this->getMockBuilder(ErpOrderCancellationItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationFilterTransferMock = $this->getMockBuilder(ErpOrderCancellationFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationCollectionTransferMock = $this->getMockBuilder(ErpOrderCancellationCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationPaginationTransfer = $this->getMockBuilder(ErpOrderCancellationPaginationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cancellationManager = new CancellationManager(
            $this->erpOrderCancellationFacadeMock,
            $this->erpOrderFacadeMock,
            $this->repositoryMock,
            $this->restDataMapperMock,
            $this->permissionCheckerMock,
            $this->restFilterToFilterMapperMock,
            $this->loggerMock,
        );
    }

    /**
     * @return void
     */
    public function testAddErpOrderCancellationPermissionDenied(): void
    {
        $this->restErpOrderCancellationRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restErpOrderCancellationAttributesTransferMock);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapFromRequest')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireErpOrderReference')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireErpOrderExternalReference')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireDebitorNumber')
            ->willReturnSelf();

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserByIdCustomerAndDebtorNumber')
            ->willReturn($this->companyUserTransferMock);

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getOriginator')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getDebitorNumber')
            ->willReturn('123');

        $this->permissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkPermission')
            ->willReturn(false);

        $this->loggerMock->expects(static::atLeastOnce())
            ->method('error');

        $response = $this->cancellationManager->addErpOrderCancellation($this->restErpOrderCancellationRequestTransferMock);

        static::assertInstanceOf(RestErrorMessageTransfer::class, $response);
    }

    /**
     * @return void
     */
    public function testAddErpOrderCancellationErpOrderNotFound(): void
    {
        $this->restErpOrderCancellationRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restErpOrderCancellationAttributesTransferMock);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapFromRequest')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireErpOrderReference')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireErpOrderExternalReference')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireDebitorNumber')
            ->willReturnSelf();

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserByIdCustomerAndDebtorNumber')
            ->willReturn($this->companyUserTransferMock);

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getOriginator')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getDebitorNumber')
            ->willReturn('123');

        $this->permissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkPermission')
            ->willReturn(true);

        $this->erpOrderFacadeMock->expects(static::atLeastOnce())
            ->method('findErpOrderByExternalReference')
            ->willReturn(null);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getErpOrderExternalReference')
            ->willReturn('extref');

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getErpOrderReference')
            ->willReturn('ref');

        $this->erpOrderFacadeMock->expects(static::atLeastOnce())
            ->method('findErpOrderByReference')
            ->willReturn(null);

        $this->loggerMock->expects(static::atLeastOnce())
            ->method('error');

        $response = $this->cancellationManager->addErpOrderCancellation($this->restErpOrderCancellationRequestTransferMock);

        static::assertInstanceOf(RestErrorMessageTransfer::class, $response);
    }

    /**
     * @return void
     */
    public function testAddErpOrderCancellationErpOrderDebtorMismatch(): void
    {
        $this->restErpOrderCancellationRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restErpOrderCancellationAttributesTransferMock);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapFromRequest')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireErpOrderReference')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireErpOrderExternalReference')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireDebitorNumber')
            ->willReturnSelf();

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserByIdCustomerAndDebtorNumber')
            ->willReturn($this->companyUserTransferMock);

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getOriginator')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getDebitorNumber')
            ->willReturn('123');

        $this->permissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkPermission')
            ->willReturn(true);

        $this->erpOrderFacadeMock->expects(static::atLeastOnce())
            ->method('findErpOrderByExternalReference')
            ->willReturn($this->erpOrderTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getErpOrderExternalReference')
            ->willReturn('extref');

        $this->erpOrderFacadeMock->expects(static::never())
            ->method('findErpOrderByReference');

        $this->loggerMock->expects(static::atLeastOnce())
            ->method('error');

        $this->erpOrderTransferMock->expects(static::atLeastOnce())
            ->method('getFkCompanyBusinessUnit')
            ->willReturn(1);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCompanyBusinessUnit')
            ->willReturn(2);

        $response = $this->cancellationManager->addErpOrderCancellation($this->restErpOrderCancellationRequestTransferMock);

        static::assertInstanceOf(RestErrorMessageTransfer::class, $response);
    }

    /**
     * @return void
     */
    public function testAddErpOrderCancellation(): void
    {
        $this->restErpOrderCancellationRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restErpOrderCancellationAttributesTransferMock);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapFromRequest')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireErpOrderReference')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireErpOrderExternalReference')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireDebitorNumber')
            ->willReturnSelf();

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserByIdCustomerAndDebtorNumber')
            ->willReturn($this->companyUserTransferMock);

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getOriginator')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getDebitorNumber')
            ->willReturn('123');

        $this->permissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkPermission')
            ->willReturn(true);

        $this->erpOrderFacadeMock->expects(static::atLeastOnce())
            ->method('findErpOrderByExternalReference')
            ->willReturn($this->erpOrderTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getErpOrderExternalReference')
            ->willReturn('extref');

        $this->erpOrderFacadeMock->expects(static::never())
            ->method('findErpOrderByReference');

        $this->loggerMock->expects(static::never())
            ->method('error');

        $this->erpOrderTransferMock->expects(static::atLeastOnce())
            ->method('getFkCompanyBusinessUnit')
            ->willReturn(1);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getFkCompanyBusinessUnit')
            ->willReturn(1);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setErpOrderReference')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setErpOrderExternalReference')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setState')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setFkCustomerRequested')
            ->willReturnSelf();

        $this->erpOrderTransferMock->expects(static::atLeastOnce())
            ->method('getReference')
            ->willReturn('ref');

        $this->erpOrderTransferMock->expects(static::atLeastOnce())
            ->method('getExternalReference')
            ->willReturn('extref');

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->erpOrderCancellationFacadeMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationResponseTransferMock);

        $this->erpOrderCancellationResponseTransferMock->expects(static::atLeastOnce())
            ->method('getErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapResponse')
            ->willReturn($this->restErpOrderCancellationTransferMock);

        $this->restErpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setErpOrder')
            ->with($this->erpOrderTransferMock)
            ->willReturnSelf();

        $response = $this->cancellationManager->addErpOrderCancellation($this->restErpOrderCancellationRequestTransferMock);

        static::assertInstanceOf(RestErpOrderCancellationResponseTransfer::class, $response);
    }

    /**
     * @return void
     */
    public function testUpdateErpOrderCancellationPermissionDenied(): void
    {
        $this->restErpOrderCancellationRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restErpOrderCancellationAttributesTransferMock);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapFromRequest')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserByIdCustomerAndDebtorNumber')
            ->willReturn($this->companyUserTransferMock);

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getOriginator')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getDebitorNumber')
            ->willReturn('123');

        $this->permissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkPermission')
            ->willReturn(false);

        $this->loggerMock->expects(static::atLeastOnce())
            ->method('error');

        $response = $this->cancellationManager->updateErpOrderCancellation($this->restErpOrderCancellationRequestTransferMock);

        static::assertInstanceOf(RestErrorMessageTransfer::class, $response);
    }

    /**
     * @return void
     */
    public function testUpdateErpOrderCancellationUpdateEntityNotFound(): void
    {
        $this->restErpOrderCancellationRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restErpOrderCancellationAttributesTransferMock);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapFromRequest')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserByIdCustomerAndDebtorNumber')
            ->willReturn($this->companyUserTransferMock);

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getOriginator')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getDebitorNumber')
            ->willReturn('123');

        $this->permissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkPermission')
            ->willReturn(true);

        $this->loggerMock->expects(static::never())
            ->method('error');

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireUuid');

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn('uuid');

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellationByUuid');

        $response = $this->cancellationManager->updateErpOrderCancellation($this->restErpOrderCancellationRequestTransferMock);

        static::assertInstanceOf(RestErrorMessageTransfer::class, $response);
        static::assertEquals(ErpOrderCancellationRestApiConstants::ERROR_CODE_NOT_FOUND, $response->getCode());
    }

    /**
     * @return void
     */
    public function testUpdateErpOrderCancellation(): void
    {
        $this->restErpOrderCancellationRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restErpOrderCancellationAttributesTransferMock);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapFromRequest')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserByIdCustomerAndDebtorNumber')
            ->willReturn($this->companyUserTransferMock);

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getOriginator')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getDebitorNumber')
            ->willReturn('123');

        $this->permissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkPermission')
            ->willReturn(true);

        $this->loggerMock->expects(static::never())
            ->method('error');

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireUuid');

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn('uuid');

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellationByUuid')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationItems')
            ->willReturn(new ArrayObject());

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getErpOrderReference')
            ->willReturn(null);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('fromArray')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setCancellationItems')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('modifiedToArray')
            ->willReturn([]);

        $this->erpOrderCancellationFacadeMock->expects(static::atLeastOnce())
            ->method('updateErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationResponseTransferMock);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapResponse')
            ->willReturn($this->restErpOrderCancellationTransferMock);

        $this->erpOrderCancellationResponseTransferMock->expects(static::atLeastOnce())
            ->method('getErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $response = $this->cancellationManager->updateErpOrderCancellation($this->restErpOrderCancellationRequestTransferMock);

        static::assertInstanceOf(RestErpOrderCancellationResponseTransfer::class, $response);
    }

    /**
     * @return void
     */
    public function testUpdateErpOrderCancellationWithItems(): void
    {
        $itemCollection = new ArrayObject();
        $itemCollection->append($this->erpOrderCancellationItemTransferMock);

        $updateCancellation = clone $this->erpOrderCancellationTransferMock;
        $updateItemCancellation = clone $this->erpOrderCancellationItemTransferMock;

        $updateItemCollection = new ArrayObject();
        $updateItemCollection->append($updateItemCancellation);

        $this->restErpOrderCancellationRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restErpOrderCancellationAttributesTransferMock);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapFromRequest')
            ->willReturn($updateCancellation);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserByIdCustomerAndDebtorNumber')
            ->willReturn($this->companyUserTransferMock);

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getOriginator')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $updateCancellation->expects(static::atLeastOnce())
            ->method('getDebitorNumber')
            ->willReturn('123');

        $this->permissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkPermission')
            ->willReturn(true);

        $this->loggerMock->expects(static::never())
            ->method('error');

        $updateCancellation->expects(static::atLeastOnce())
            ->method('requireUuid');

        $updateCancellation->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn('uuid');

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellationByUuid')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $updateCancellation->expects(static::atLeastOnce())
            ->method('getCancellationItems')
            ->willReturn($updateItemCollection);

        $updateItemCancellation->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn('sku');

        $updateItemCancellation->expects(static::atLeastOnce())
            ->method('getLineId')
            ->willReturn('1000');

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationItems')
            ->willReturn($itemCollection);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn('sku2');

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getLineId')
            ->willReturn('2000');

        $updateCancellation->expects(static::atLeastOnce())
            ->method('getErpOrderReference')
            ->willReturn(null);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('fromArray')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setCancellationItems')
            ->willReturnCallback(static function (ArrayObject $itemCollection) {
                static::assertCount(2, $itemCollection);

                return $itemCollection;
            });

        $updateCancellation->expects(static::atLeastOnce())
            ->method('modifiedToArray')
            ->willReturn([]);

        $this->erpOrderCancellationFacadeMock->expects(static::atLeastOnce())
            ->method('updateErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationResponseTransferMock);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapResponse')
            ->willReturn($this->restErpOrderCancellationTransferMock);

        $this->erpOrderCancellationResponseTransferMock->expects(static::atLeastOnce())
            ->method('getErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $response = $this->cancellationManager->updateErpOrderCancellation($this->restErpOrderCancellationRequestTransferMock);

        static::assertInstanceOf(RestErpOrderCancellationResponseTransfer::class, $response);
    }

    /**
     * @return void
     */
    public function testDeleteErpOrderCancellationPermissionDenied(): void
    {
        $this->restErpOrderCancellationRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restErpOrderCancellationAttributesTransferMock);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapFromRequest')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserByIdCustomerAndDebtorNumber')
            ->willReturn($this->companyUserTransferMock);

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getOriginator')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getDebitorNumber')
            ->willReturn('123');

        $this->permissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkPermission')
            ->willReturn(false);

        $this->loggerMock->expects(static::atLeastOnce())
            ->method('error');

        $response = $this->cancellationManager->deleteErpOrderCancellation($this->restErpOrderCancellationRequestTransferMock);

        static::assertInstanceOf(RestErrorMessageTransfer::class, $response);
    }

    /**
     * @return void
     */
    public function testDeleteErpOrderCancellationDeleteEntityNotFound(): void
    {
        $this->restErpOrderCancellationRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restErpOrderCancellationAttributesTransferMock);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapFromRequest')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserByIdCustomerAndDebtorNumber')
            ->willReturn($this->companyUserTransferMock);

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getOriginator')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getDebitorNumber')
            ->willReturn('123');

        $this->permissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkPermission')
            ->willReturn(true);

        $this->loggerMock->expects(static::atLeastOnce())
            ->method('error');

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireUuid');

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn('uuid');

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellationByUuid')
            ->willReturn(null);

        $response = $this->cancellationManager->deleteErpOrderCancellation($this->restErpOrderCancellationRequestTransferMock);

        static::assertInstanceOf(RestErrorMessageTransfer::class, $response);
        static::assertEquals(ErpOrderCancellationRestApiConstants::ERROR_CODE_DELETE, $response->getCode());
    }

    /**
     * @return void
     */
    public function testDeleteErpOrderCancellation(): void
    {
        $this->restErpOrderCancellationRequestTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restErpOrderCancellationAttributesTransferMock);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapFromRequest')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserByIdCustomerAndDebtorNumber')
            ->willReturn($this->companyUserTransferMock);

        $this->restErpOrderCancellationAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getOriginator')
            ->willReturn($this->restCustomerTransferMock);

        $this->restCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getDebitorNumber')
            ->willReturn('123');

        $this->permissionCheckerMock->expects(static::atLeastOnce())
            ->method('checkPermission')
            ->willReturn(true);

        $this->loggerMock->expects(static::never())
            ->method('error');

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireUuid');

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn('uuid');

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellationByUuid')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->erpOrderCancellationFacadeMock->expects(static::atLeastOnce())
            ->method('deleteErpOrderCancellationByIdErpOrderCancellation');

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getIdErpOrderCancellation')->willReturn(1);

        $response = $this->cancellationManager->deleteErpOrderCancellation($this->restErpOrderCancellationRequestTransferMock);

        static::assertInstanceOf(RestErpOrderCancellationResponseTransfer::class, $response);
    }

    /**
     * @return void
     */
    public function testGetErpOrderCancellation(): void
    {
        $cancellationCollection = new ArrayObject();
        $cancellationCollection->append($this->erpOrderCancellationTransferMock);

        $this->restFilterToFilterMapperMock->expects(static::atLeastOnce())
            ->method('fromRestRequest')
            ->willReturn($this->erpOrderCancellationFilterTransferMock);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellation')
            ->willReturn($this->erpOrderCancellationCollectionTransferMock);

        $this->erpOrderCancellationCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getCancellations')
            ->willReturn($cancellationCollection);

        $this->restDataMapperMock->expects(static::atLeastOnce())
            ->method('mapResponse')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->restErpOrderCancellationTransferMock);

        $this->erpOrderCancellationPaginationTransfer->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->repositoryMock->expects(static::atLeastOnce())
            ->method('getErpOrderCancellationPagination')
            ->willReturn($this->erpOrderCancellationPaginationTransfer);

        $response = $this->cancellationManager->getErpOrderCancellation($this->restErpOrderCancellationRequestTransferMock);

        static::assertInstanceOf(RestErpOrderCancellationCollectionResponseTransfer::class, $response);
    }
}
