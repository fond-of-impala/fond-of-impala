<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacade;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyUserCartsRestApiToCompanyUserReferenceFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacade|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserReferenceFacade|MockObject $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyUserTransfer $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyUserResponseTransfer $companyUserResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCompanyUserReferenceFacadeBridge
     */
    protected CompanyUserCartsRestApiToCompanyUserReferenceFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(CompanyUserReferenceFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CompanyUserCartsRestApiToCompanyUserReferenceFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyUserByCompanyUserReference(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('findCompanyUserByCompanyUserReference')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->bridge->findCompanyUserByCompanyUserReference(
                $this->companyUserTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetIdCompanyUserByCompanyUserReferenceAndIdCustomer(): void
    {
        $companyUserReference = 'foo';
        $idCustomer = 1;
        $idCompanyUser = 3;

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getIdCompanyUserByCompanyUserReferenceAndIdCustomer')
            ->with($companyUserReference, $idCustomer)
            ->willReturn($idCompanyUser);

        static::assertEquals(
            $idCompanyUser,
            $this->bridge->getIdCompanyUserByCompanyUserReferenceAndIdCustomer(
                $companyUserReference,
                $idCustomer,
            ),
        );
    }
}
