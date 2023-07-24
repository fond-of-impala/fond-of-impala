<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Communication\Plugin\CompanyExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleFacade;
use Generated\Shared\Transfer\CompanyResponseTransfer;

class CompanyTypeRoleCompanyPostCreatePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleFacade
     */
    protected $companyTypeRoleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Communication\Plugin\CompanyExtension\CompanyTypeRoleCompanyPostCreatePlugin
     */
    protected $companyTypeRoleCompanyPostCreatePlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeRoleFacadeMock = $this->getMockBuilder(CompanyTypeRoleFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeRoleCompanyPostCreatePlugin = new CompanyTypeRoleCompanyPostCreatePlugin();

        $this->companyTypeRoleCompanyPostCreatePlugin->setFacade($this->companyTypeRoleFacadeMock);
    }

    /**
     * @return void
     */
    public function testPostCreate(): void
    {
        $this->companyTypeRoleFacadeMock->expects($this->atLeastOnce())
            ->method('assignPredefinedCompanyRolesToNewCompany')
            ->with($this->companyResponseTransferMock)
            ->willReturn($this->companyResponseTransferMock);

        $companyResponseTransfer = $this->companyTypeRoleCompanyPostCreatePlugin
            ->postCreate($this->companyResponseTransferMock);

        $this->assertEquals($this->companyResponseTransferMock, $companyResponseTransfer);
    }
}
