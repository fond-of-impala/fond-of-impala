<?php

namespace FondOfImpala\Zed\NavisionCompany\Communication\Plugin\CompanyExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

class IsBlockedCompanyPreSavePluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\NavisionCompany\Communication\Plugin\CompanyExtension\IsBlockedCompanyPreSavePlugin
     */
    protected $isBlockedCompanyPreSavePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var string
     */
    protected $string;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->string = 'string';

        $this->isBlockedCompanyPreSavePlugin = new IsBlockedCompanyPreSavePlugin();
    }

    /**
     * @return void
     */
    public function testPreSaveValidationNull(): void
    {
        $this->assertInstanceOf(
            CompanyResponseTransfer::class,
            $this->isBlockedCompanyPreSavePlugin->preSaveValidation($this->companyResponseTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testPreSaveValidation(): void
    {
        $this->companyResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTransfer')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getBlockedFor')
            ->willReturn($this->string);

        $this->assertInstanceOf(
            CompanyResponseTransfer::class,
            $this->isBlockedCompanyPreSavePlugin->preSaveValidation($this->companyResponseTransferMock),
        );
    }
}
