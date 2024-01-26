<?php

namespace FondOfImpala\Zed\CollaborativeCart\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacadeInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CollaborativeCartToCompanyUserReferenceFacadeBridgeTest extends Unit
{
    protected MockObject|CompanyUserReferenceFacadeInterface $companyUserReferenceFacadeMock;

    protected MockObject|CompanyUserTransfer $companyUserTransferMock;

    protected MockObject|CompanyUserResponseTransfer $companyUserResponseTransferMock;

    protected CollaborativeCartToCompanyUserReferenceFacadeBridge $collaborativeCartToCompanyUserReferenceFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserReferenceFacadeMock = $this->getMockBuilder(CompanyUserReferenceFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartToCompanyUserReferenceFacadeBridge = new CollaborativeCartToCompanyUserReferenceFacadeBridge(
            $this->companyUserReferenceFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyUserByCompanyUserReference(): void
    {
        $this->companyUserReferenceFacadeMock->expects(self::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        self::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->collaborativeCartToCompanyUserReferenceFacadeBridge
                ->findCompanyUserByCompanyUserReference($this->companyUserTransferMock),
        );
    }
}
