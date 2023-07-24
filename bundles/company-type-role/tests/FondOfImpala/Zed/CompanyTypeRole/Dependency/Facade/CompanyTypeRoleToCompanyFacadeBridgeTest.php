<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Spryker\Zed\Company\Business\CompanyFacadeInterface;

class CompanyTypeRoleToCompanyFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected $companyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    protected $companyCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyFacadeBridge
     */
    protected $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyFacadeMock = $this->getMockBuilder(CompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyCollectionTransferMock = $this->getMockBuilder(CompanyCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CompanyTypeRoleToCompanyFacadeBridge($this->companyFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetCompanies(): void
    {
        $this->companyFacadeMock->expects(static::atLeastOnce())
            ->method('getCompanies')
            ->willReturn($this->companyCollectionTransferMock);

        $companyCollectionTransfer = $this->bridge->getCompanies();

        static::assertEquals($this->companyCollectionTransferMock, $companyCollectionTransfer);
    }
}
