<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUser;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapperInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutor;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CustomerReaderInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Business\Writer\CustomerWriterInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\WriteCompanyUserPermissionPlugin;
use FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\RestCompanyTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;

class CompanyUserWriterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CustomerReaderInterface
     */
    protected $customerReaderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Business\Writer\CustomerWriterInterface
     */
    protected $customerWriterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyFacadeInterface
     */
    protected $companyFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserFacadeInterface
     */
    protected $companyUserFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper\CompanyUserMapperInterface
     */
    protected $companyUserMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface
     */
    protected $restApiErrorInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface
     */
    protected $companyUserReaderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface
     */
    protected $utilTextServiceInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig
     */
    protected $companyUsersRestApiConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer
     */
    protected $restCompanyUsersRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    protected $restCompanyUsersResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCustomerTransfer
     */
    protected $restCustomerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Business\PluginExecutor\CompanyUserPluginExecutor
     */
    protected $companyUserPluginExecutorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Customer\Business\Exception\CustomerNotFoundException
     */
    protected $customerNotFoundExceptionMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\LocaleTransfer
     */
    protected $localeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToPermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\RestCustomerTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $currentRestCustomerTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $currentCompanyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $restCompanyTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation\RestApiErrorInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restApiErrorMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader\CompanyUserReaderInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserReaderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUser\CompanyUserWriter
     */
    protected $companyUserWriter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerReaderMock = $this->getMockBuilder(CustomerReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerWriterMock = $this->getMockBuilder(CustomerWriterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserMapperMock = $this->getMockBuilder(CompanyUserMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restApiErrorMock = $this->getMockBuilder(RestApiErrorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersRestApiConfigMock = $this->getMockBuilder(CompanyUsersRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersRequestAttributesTransferMock = $this->getMockBuilder(RestCompanyUsersRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyTransferMock = $this->getMockBuilder(RestCompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerTransferMock = $this->getMockBuilder(RestCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUsersResponseTransferMock = $this->getMockBuilder(RestCompanyUsersResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currentRestCustomerTransferMock = $this->getMockBuilder(RestCustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserPluginExecutorMock = $this->getMockBuilder(CompanyUserPluginExecutor::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currentCompanyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeTransferMock = $this->getMockBuilder(LocaleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyUsersRestApiToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserWriter = new CompanyUserWriter(
            $this->customerReaderMock,
            $this->customerWriterMock,
            $this->companyFacadeMock,
            $this->companyBusinessUnitFacadeMock,
            $this->companyUserFacadeMock,
            $this->companyUserMapperMock,
            $this->restApiErrorMock,
            $this->companyUserReaderMock,
            $this->companyUsersRestApiConfigMock,
            $this->permissionFacadeMock,
            $this->companyUserPluginExecutorMock,
        );
    }

    /**
     * @return void
     */
    public function testCreateWithCustomerRegistration(): void
    {
        $currentIdCustomer = 6;
        $currentIdCompanyUser = 6;
        $companyUuid = 'b5b4cbec-2a8b-4f61-9286-3f2bbf58a6b7';
        $idCompany = 1;

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($companyUuid);

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyByUuid')
            ->with(
                static::callback(
                    static fn (CompanyTransfer $companyTransfer): bool => $companyTransfer->getUuid() === $companyUuid,
                ),
            )->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($idCompany);

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCurrentCustomer')
            ->willReturn($this->currentRestCustomerTransferMock);

        $this->currentRestCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($currentIdCustomer);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeMock->expects(static::atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->customerReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUsersRequestAttributes')
            ->with($this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->companyUserMapperMock->expects(static::atLeastOnce())
            ->method('mapRestCompanyUserRequestAttributesTransferToCompanyUserTransfer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCompany')
            ->with($this->companyTransferMock)
            ->willReturnSelf();

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setFkCompany')
            ->willReturnSelf();

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCompanyBusinessUnit')
            ->willReturnSelf();

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setFkCompanyBusinessUnit')
            ->willReturnSelf();

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCustomer')
            ->willReturnSelf();

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setFkCustomer')
            ->willReturnSelf();

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('doesCompanyUserAlreadyExist')
            ->willReturn(false);

        $this->companyUserPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePreCreatePlugins')
            ->with($this->companyUserTransferMock, $this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('create')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostCreatePlugins')
            ->with($this->companyUserTransferMock, $this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        static::assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $currentIdCustomer = 6;
        $currentIdCompanyUser = 6;
        $companyUuid = 'b5b4cbec-2a8b-4f61-9286-3f2bbf58a6b7';
        $idCompany = 1;

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($companyUuid);

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyByUuid')
            ->with(
                static::callback(
                    static fn (CompanyTransfer $companyTransfer): bool => $companyTransfer->getUuid() === $companyUuid,
                ),
            )->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($idCompany);

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCurrentCustomer')
            ->willReturn($this->currentRestCustomerTransferMock);

        $this->currentRestCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($currentIdCustomer);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeMock->expects(static::atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->customerReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUsersRequestAttributes')
            ->with($this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn(null);

        $this->customerWriterMock->expects(static::atLeastOnce())
            ->method('createByRestCompanyUsersRequestAttributes')
            ->with($this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyUserMapperMock->expects(static::atLeastOnce())
            ->method('mapRestCompanyUserRequestAttributesTransferToCompanyUserTransfer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCompany')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setFkCompany')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCompanyBusinessUnit')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setFkCompanyBusinessUnit')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCustomer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setFkCustomer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('doesCompanyUserAlreadyExist')
            ->willReturn(false);

        $this->companyUserPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePreCreatePlugins')
            ->with($this->companyUserTransferMock, $this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('create')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyUserPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostCreatePlugins')
            ->with($this->companyUserTransferMock, $this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        static::assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyNotFoundError(): void
    {
        $companyUuid = 'b5b4cbec-2a8b-4f61-9286-3f2bbf58a6b7';

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($companyUuid);

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyByUuid')
            ->with(
                static::callback(
                    static fn (CompanyTransfer $companyTransfer): bool => $companyUuid === $companyTransfer->getUuid(),
                ),
            )->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        static::assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyBusinessUnitNull(): void
    {
        $currentIdCustomer = 6;
        $currentIdCompanyUser = 6;
        $idCompany = 1;
        $companyUuid = 'b5b4cbec-2a8b-4f61-9286-3f2bbf58a6b7';

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($companyUuid);

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyByUuid')
            ->with(
                static::callback(
                    static fn (CompanyTransfer $companyTransfer): bool => $companyUuid === $companyTransfer->getUuid(),
                ),
            )->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($idCompany);

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCurrentCustomer')
            ->willReturn($this->currentRestCustomerTransferMock);

        $this->currentRestCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($currentIdCustomer);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeMock->expects(static::atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn(null);

        static::assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserAlreadyExists(): void
    {
        $currentIdCustomer = 6;
        $currentIdCompanyUser = 6;
        $idCompany = 1;
        $companyUuid = 'b5b4cbec-2a8b-4f61-9286-3f2bbf58a6b7';

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($companyUuid);

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyByUuid')
            ->with(
                static::callback(
                    static fn (CompanyTransfer $companyTransfer): bool => $companyUuid === $companyTransfer->getUuid(),
                ),
            )->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($idCompany);

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCurrentCustomer')
            ->willReturn($this->currentRestCustomerTransferMock);

        $this->currentRestCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($currentIdCustomer);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeMock->expects(static::atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->customerReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUsersRequestAttributes')
            ->with($this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyUserMapperMock->expects(static::atLeastOnce())
            ->method('mapRestCompanyUserRequestAttributesTransferToCompanyUserTransfer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCompany')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setFkCompany')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCompanyBusinessUnit')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setFkCompanyBusinessUnit')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCustomer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setFkCustomer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('doesCompanyUserAlreadyExist')
            ->willReturn(true);

        static::assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyUserResponseNotSuccessful(): void
    {
        $currentIdCustomer = 6;
        $currentIdCompanyUser = 6;
        $idCompany = 1;
        $companyUuid = 'b5b4cbec-2a8b-4f61-9286-3f2bbf58a6b7';

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->restCompanyTransferMock);

        $this->restCompanyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($companyUuid);

        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyByUuid')
            ->with(
                static::callback(
                    static fn (CompanyTransfer $companyTransfer): bool => $companyUuid === $companyTransfer->getUuid(),
                ),
            )->willReturn($this->companyResponseTransferMock);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->companyResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompany')
            ->willReturn($idCompany);

        $this->restCompanyUsersRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getCurrentCustomer')
            ->willReturn($this->currentRestCustomerTransferMock);

        $this->currentRestCustomerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($currentIdCustomer);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('getByIdCustomerAndIdCompany')
            ->willReturn($this->currentCompanyUserTransferMock);

        $this->currentCompanyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($currentIdCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->with(WriteCompanyUserPermissionPlugin::KEY, $currentIdCompanyUser)
            ->willReturn(true);

        $this->companyBusinessUnitFacadeMock->expects(static::atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->customerReaderMock->expects(static::atLeastOnce())
            ->method('getByRestCompanyUsersRequestAttributes')
            ->with($this->restCompanyUsersRequestAttributesTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->companyUserMapperMock->expects(static::atLeastOnce())
            ->method('mapRestCompanyUserRequestAttributesTransferToCompanyUserTransfer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCompany')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setFkCompany')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCompanyBusinessUnit')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setFkCompanyBusinessUnit')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setCustomer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('setFkCustomer')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserReaderMock->expects(static::atLeastOnce())
            ->method('doesCompanyUserAlreadyExist')
            ->willReturn(false);

        $this->companyUserFacadeMock->expects(static::atLeastOnce())
            ->method('create')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        static::assertInstanceOf(
            RestCompanyUsersResponseTransfer::class,
            $this->companyUserWriter->create(
                $this->restCompanyUsersRequestAttributesTransferMock,
            ),
        );
    }
}
