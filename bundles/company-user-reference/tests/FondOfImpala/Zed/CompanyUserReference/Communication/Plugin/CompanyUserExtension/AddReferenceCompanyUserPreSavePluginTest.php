<?php

namespace FondOfImpala\Zed\CompanyUserReference\Communication\Plugin\CompanyUserExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacade;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class AddReferenceCompanyUserPreSavePluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Communication\Plugin\CompanyUserExtension\AddReferenceCompanyUserPreSavePlugin
     */
    protected $addReferenceCompanyUserPreSavePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReference\Business\CompanyUserReferenceFacade
     */
    protected $companyUserReferenceFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var string
     */
    protected $generatedCompanyUserReference;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceFacadeMock = $this->getMockBuilder(CompanyUserReferenceFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->generatedCompanyUserReference = 'generated-company-user-reference';

        $this->addReferenceCompanyUserPreSavePlugin = new AddReferenceCompanyUserPreSavePlugin();
        $this->addReferenceCompanyUserPreSavePlugin->setFacade($this->companyUserReferenceFacadeMock);
    }

    /**
     * @return void
     */
    public function testPreSave(): void
    {
        $this->companyUserResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn(null);

        $this->companyUserReferenceFacadeMock->expects($this->atLeastOnce())
            ->method('generateCompanyUserReference')
            ->willReturn($this->generatedCompanyUserReference);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('setCompanyUserReference')
            ->with($this->generatedCompanyUserReference)
            ->willReturnSelf();

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->addReferenceCompanyUserPreSavePlugin->preSave(
                $this->companyUserResponseTransferMock,
            ),
        );
    }
}
