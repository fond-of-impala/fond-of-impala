<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacade;
use Generated\Shared\Transfer\CompanyResponseTransfer;

class CompanyUserCompanyAssignerCompanyPostCreatePluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyExtension\CompanyUserCompanyAssignerCompanyPostCreatePlugin
     */
    protected $companyUserCompanyAssignerCompanyPostCreatePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacade
     */
    protected $companyUserCompanyAssignerFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserCompanyAssignerFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCompanyAssignerCompanyPostCreatePlugin = new CompanyUserCompanyAssignerCompanyPostCreatePlugin();
        $this->companyUserCompanyAssignerCompanyPostCreatePlugin->setFacade($this->companyUserCompanyAssignerFacadeMock);
    }

    /**
     * @return void
     */
    public function testPostCreate(): void
    {
        $this->companyUserCompanyAssignerFacadeMock->expects($this->atLeastOnce())
            ->method('addManufacturerUsersToCompany')
            ->with($this->companyResponseTransferMock)
            ->willReturn($this->companyResponseTransferMock);

        $this->assertInstanceOf(
            CompanyResponseTransfer::class,
            $this->companyUserCompanyAssignerCompanyPostCreatePlugin->postCreate(
                $this->companyResponseTransferMock,
            ),
        );
    }
}
