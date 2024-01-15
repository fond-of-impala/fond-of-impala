<?php

namespace FondOfImpala\Zed\CompanyUserQuote\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacadeInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserQuoteToCompanyUserReferenceFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserQuote\Dependency\Facade\CompanyUserQuoteToCompanyUserReferenceFacadeBridge
     */
    protected $companyUserQuoteToCompanyUserReferenceFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacadeInterface
     */
    protected $companyUserReferenceFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUsersRestApi\Business\CompanyUsersRestApiFacade
     */
    protected $companyUsersRestApiFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserReferenceFacadeInterfaceMock = $this->getMockBuilder(CompanyUserReferenceFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserQuoteToCompanyUserReferenceFacadeBridge = new CompanyUserQuoteToCompanyUserReferenceFacadeBridge(
            $this->companyUserReferenceFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyUserByCompanyUserReference(): void
    {
        $this->companyUserReferenceFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUserQuoteToCompanyUserReferenceFacadeBridge->findCompanyUserByCompanyUserReference(
                $this->companyUserTransferMock,
            ),
        );
    }
}
