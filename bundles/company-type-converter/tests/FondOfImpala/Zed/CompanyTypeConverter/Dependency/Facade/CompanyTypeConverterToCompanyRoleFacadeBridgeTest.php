<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;

class CompanyTypeConverterToCompanyRoleFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected $companyRoleTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    protected $companyRoleResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer
     */
    protected $companyRoleCriteriaFilterTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Dependency\Facade\CompanyTypeConverterToCompanyRoleFacadeBridge
     */
    protected $companyTypeConverterToCompanyRoleFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleResponseTransferMock = $this->getMockBuilder(CompanyRoleResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCriteriaFilterTransferMock = $this->getMockBuilder(CompanyRoleCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterToCompanyRoleFacadeBridge = new CompanyTypeConverterToCompanyRoleFacadeBridge(
            $this->companyRoleFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('create')
            ->with($this->companyRoleTransferMock)
            ->willReturn($this->companyRoleResponseTransferMock);

        $companyRoleResponseTransfer = $this->companyRoleFacadeMock
            ->create($this->companyRoleTransferMock);

        $this->assertEquals($this->companyRoleResponseTransferMock, $companyRoleResponseTransfer);
        $this->assertInstanceOf(
            CompanyRoleResponseTransfer::class,
            $companyRoleResponseTransfer,
        );
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('delete')
            ->with($this->companyRoleTransferMock)
            ->willReturn($this->companyRoleResponseTransferMock);

        $companyRoleResponseTransfer = $this->companyRoleFacadeMock
            ->delete($this->companyRoleTransferMock);

        $this->assertEquals($this->companyRoleResponseTransferMock, $companyRoleResponseTransfer);
        $this->assertInstanceOf(
            CompanyRoleResponseTransfer::class,
            $companyRoleResponseTransfer,
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyRoleCollection(): void
    {
        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->with($this->companyRoleCriteriaFilterTransferMock)
            ->willReturn($this->companyRoleCollectionTransferMock);

        $companyRoleCollectionTransfer = $this->companyRoleFacadeMock
            ->getCompanyRoleCollection($this->companyRoleCriteriaFilterTransferMock);

        $this->assertEquals($this->companyRoleCollectionTransferMock, $companyRoleCollectionTransfer);
        $this->assertInstanceOf(
            CompanyRoleCollectionTransfer::class,
            $companyRoleCollectionTransfer,
        );
    }
}
