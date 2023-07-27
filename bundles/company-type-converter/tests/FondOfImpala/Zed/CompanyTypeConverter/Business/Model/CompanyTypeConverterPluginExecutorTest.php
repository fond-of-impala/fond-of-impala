<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyTransfer;

class CompanyTypeConverterPluginExecutorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverter\Business\Model\CompanyTypeConverterPluginExecutor
     */
    protected $companyTypeConverterPluginExecutor;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeConverterPluginExecutor = new CompanyTypeConverterPluginExecutor();
    }

    /**
     * @return void
     */
    public function testExecuteCompanyTypeConverterPreSavePlugins(): void
    {
        $this->assertInstanceOf(
            CompanyTransfer::class,
            $this->companyTypeConverterPluginExecutor
                ->executeCompanyTypeConverterPreSavePlugins($this->companyTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExecuteCompanyTypeConverterPostSavePlugins(): void
    {
        $this->assertInstanceOf(
            CompanyTransfer::class,
            $this->companyTypeConverterPluginExecutor
                ->executeCompanyTypeConverterPostSavePlugins($this->companyTransferMock),
        );
    }
}
