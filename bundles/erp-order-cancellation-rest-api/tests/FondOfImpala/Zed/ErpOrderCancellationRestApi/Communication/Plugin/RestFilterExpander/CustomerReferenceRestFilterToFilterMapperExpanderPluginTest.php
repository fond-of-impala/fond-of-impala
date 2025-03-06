<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\RestFilterExpander;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\ErpOrderCancellationRestApiCommunicationFactory;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToCompanyUserReferenceFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToCustomerFacadeInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CustomerReferenceRestFilterToFilterMapperExpanderPluginTest extends Unit
{
    protected MockObject|CompanyUserTransfer $companyUserTransferMock;

    protected MockObject|CompanyUserResponseTransfer $companyUserResponseTransferMock;

    protected MockObject|ErpOrderCancellationRestApiToCompanyUserReferenceFacadeInterface $companyUserReferenceFacadeMock;

    protected MockObject|ErpOrderCancellationRestApiToCustomerFacadeInterface $customerFacadeMock;

    protected MockObject|CustomerTransfer $customerTransferMock;

    protected MockObject|ErpOrderCancellationRestApiCommunicationFactory $factoryMock;

    protected MockObject|PermissionFacadeInterface $permissionFacadeMock;

    protected MockObject|RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransferMock;

    protected MockObject|ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransferMock;

    protected CustomerReferenceRestFilterToFilterMapperExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserReferenceFacadeMock = $this
            ->getMockBuilder(ErpOrderCancellationRestApiToCompanyUserReferenceFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this
            ->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this
            ->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerFacadeMock = $this
            ->getMockBuilder(ErpOrderCancellationRestApiToCustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this
            ->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this
            ->getMockBuilder(ErpOrderCancellationRestApiCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this
            ->getMockBuilder(PermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->erpOrderCancellationFilterTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationFilterTransferMock = $this
            ->getMockBuilder(RestErpOrderCancellationFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CustomerReferenceRestFilterToFilterMapperExpanderPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $companyUserReference = 'companyUserReference';
        $customerReference = 'customerReference';
        $idCustomer = 1;
        $idCompanyUser = 1;

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReferenceFacade')
            ->willReturn($this->companyUserReferenceFacadeMock);

        $this->companyUserReferenceFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getPermissionFacade')
            ->willReturn($this->permissionFacadeMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->willReturn(false);

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerFacade')
            ->willReturn($this->customerFacadeMock);

        $this->customerFacadeMock->expects(static::atLeastOnce())
            ->method('findByReference')
            ->with($customerReference)
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($idCustomer);

        $this->erpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('setFkCustomer')
            ->with($idCustomer)
            ->willReturn($this->erpOrderCancellationFilterTransferMock);

        static::assertEquals(
            $this->erpOrderCancellationFilterTransferMock,
            $this->plugin->expand(
                $this->restErpOrderCancellationFilterTransferMock,
                $this->erpOrderCancellationFilterTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithTruePermission(): void
    {
        $companyUserReference = 'companyUserReference';
        $idCompanyUser = 1;

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReferenceFacade')
            ->willReturn($this->companyUserReferenceFacadeMock);

        $this->companyUserReferenceFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getPermissionFacade')
            ->willReturn($this->permissionFacadeMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->willReturn(true);

        static::assertEquals(
            $this->erpOrderCancellationFilterTransferMock,
            $this->plugin->expand(
                $this->restErpOrderCancellationFilterTransferMock,
                $this->erpOrderCancellationFilterTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithNoCustomerReference(): void
    {
        $companyUserReference = 'companyUserReference';
        $customerReference = 'customerReference';
        $idCompanyUser = 1;

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReferenceFacade')
            ->willReturn($this->companyUserReferenceFacadeMock);

        $this->companyUserReferenceFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getPermissionFacade')
            ->willReturn($this->permissionFacadeMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUser')
            ->willReturn($idCompanyUser);

        $this->permissionFacadeMock->expects(static::atLeastOnce())
            ->method('can')
            ->willReturn(false);

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($customerReference);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerFacade')
            ->willReturn($this->customerFacadeMock);

        $this->customerFacadeMock->expects(static::atLeastOnce())
            ->method('findByReference')
            ->with($customerReference)
            ->willReturn(null);

        static::assertEquals(
            $this->erpOrderCancellationFilterTransferMock,
            $this->plugin->expand(
                $this->restErpOrderCancellationFilterTransferMock,
                $this->erpOrderCancellationFilterTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithNoCompanyUserReference(): void
    {
        $companyUserReference = 'companyUserReference';

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReferenceFacade')
            ->willReturn($this->companyUserReferenceFacadeMock);

        $this->companyUserReferenceFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->restErpOrderCancellationFilterTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn(null);

        static::assertEquals(
            $this->erpOrderCancellationFilterTransferMock,
            $this->plugin->expand(
                $this->restErpOrderCancellationFilterTransferMock,
                $this->erpOrderCancellationFilterTransferMock,
            ),
        );
    }
}
