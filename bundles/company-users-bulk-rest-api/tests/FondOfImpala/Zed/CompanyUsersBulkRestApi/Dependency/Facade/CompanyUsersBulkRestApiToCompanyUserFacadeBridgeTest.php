<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;

class CompanyUsersBulkRestApiToCompanyUserFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToCompanyUserFacadeBridge
     */
    protected CompanyUsersBulkRestApiToCompanyUserFacadeBridge $facadeBridge;

    /**
     * @var \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserFacadeInterface|MockObject $companyUserFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserTransfer|MockObject $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserResponseTransfer|MockObject $companyUserResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserFacadeMock = $this->getMockBuilder(CompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeBridge = new CompanyUsersBulkRestApiToCompanyUserFacadeBridge(
            $this->companyUserFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->companyUserFacadeMock
            ->expects(static::atLeastOnce())
            ->method('create')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->facadeBridge->create($this->companyUserTransferMock);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->companyUserFacadeMock
            ->expects(static::atLeastOnce())
            ->method('update')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->facadeBridge->update($this->companyUserTransferMock);
    }

    /**
     * @return void
     */
    public function testDeleteCompanyUser(): void
    {
        $this->companyUserFacadeMock
            ->expects(static::atLeastOnce())
            ->method('deleteCompanyUser')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->facadeBridge->deleteCompanyUser($this->companyUserTransferMock);
    }
}
