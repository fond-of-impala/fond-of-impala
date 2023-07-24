<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;

class CompanyTypeRoleToCompanyRoleFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected $companyRoleTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    protected $companyRoleResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer|\PHPUnit\Framework\MockObject\MockObject|mixed
     */
    protected $companyRoleCriteriaFilterTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeBridge
     */
    protected $companyTypeRoleToCompanyRoleFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleResponseTransferMock = $this->getMockBuilder(CompanyRoleResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCriteriaFilterTransferMock = $this->getMockBuilder(CompanyRoleCriteriaFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRoleToCompanyRoleFacadeBridge = new CompanyTypeRoleToCompanyRoleFacadeBridge(
            $this->companyRoleFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('create')
            ->with($this->companyRoleTransferMock)
            ->willReturn($this->companyRoleResponseTransferMock);

        $companyRoleResponseTransfer = $this->companyTypeRoleToCompanyRoleFacadeBridge
            ->create($this->companyRoleTransferMock);

        static::assertEquals($this->companyRoleResponseTransferMock, $companyRoleResponseTransfer);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($this->companyRoleTransferMock);

        $this->companyTypeRoleToCompanyRoleFacadeBridge
            ->update($this->companyRoleTransferMock);
    }

    /**
     * @return void
     */
    public function testGetCompanyRoleCollection(): void
    {
        $this->companyRoleFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->with($this->companyRoleCriteriaFilterTransferMock)
            ->willReturn($this->companyRoleCollectionTransferMock);

        $companyRoleCollectionTransfer = $this->companyTypeRoleToCompanyRoleFacadeBridge
            ->getCompanyRoleCollection($this->companyRoleCriteriaFilterTransferMock);

        static::assertEquals($this->companyRoleCollectionTransferMock, $companyRoleCollectionTransfer);
    }
}
