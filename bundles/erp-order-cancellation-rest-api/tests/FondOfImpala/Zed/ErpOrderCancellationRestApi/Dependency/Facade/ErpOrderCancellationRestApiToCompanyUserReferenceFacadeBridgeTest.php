<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacadeInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationRestApiToCompanyUserReferenceFacadeBridgeTest extends Unit
{
    protected ErpOrderCancellationRestApiToCompanyUserReferenceFacadeBridge $bridge;
    protected MockObject|CompanyUserReferenceFacadeInterface $companyUserReferenceFacadeMock;

    protected MockObject|CompanyUserTransfer $companyUserTransferMock;

    protected MockObject|CompanyUserResponseTransfer $companyUserResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserReferenceFacadeMock = $this
            ->getMockBuilder(CompanyUserReferenceFacadeInterface::class)
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

        $this->bridge = new ErpOrderCancellationRestApiToCompanyUserReferenceFacadeBridge(
            $this->companyUserReferenceFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyUserByCompanyUserReference(): void
    {
        $this->companyUserReferenceFacadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $companyUserResponseTransfer = $this->bridge
            ->findCompanyUserByCompanyUserReference($this->companyUserTransferMock);

        static::assertEquals($this->companyUserResponseTransferMock, $companyUserResponseTransfer);
    }
}
