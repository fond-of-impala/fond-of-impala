<?php

namespace FondOfImpala\Zed\CompanyTypeDataImport\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;
use Spryker\Zed\DataImport\Business\Model\DataImporterInterface;

class CompanyTypeDataImportFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\DataImporterConfigurationTransfer
     */
    protected $dataImporterConfigurationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\DataImporterReportTransfer
     */
    protected $dataImporterReportTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyTypeDataImport\Business\CompanyTypeDataImportBusinessFactory
     */
    protected $companyTypeDataImportBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    protected $companyTypeDataImporterMock;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeDataImport\Business\CompanyTypeDataImportFacade
     */
    protected $companyTypeDataImportFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->dataImporterConfigurationTransferMock = $this->getMockBuilder(DataImporterConfigurationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dataImporterReportTransferMock = $this->getMockBuilder(DataImporterReportTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeDataImportBusinessFactoryMock = $this->getMockBuilder(CompanyTypeDataImportBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeDataImporterMock = $this->getMockBuilder(DataImporterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeDataImportFacade = new CompanyTypeDataImportFacade();

        $this->companyTypeDataImportFacade->setFactory($this->companyTypeDataImportBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testImportCompanyTypes(): void
    {
        $this->companyTypeDataImportBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyTypeDataImport')
            ->willReturn($this->companyTypeDataImporterMock);

        $this->companyTypeDataImporterMock->expects($this->atLeastOnce())
            ->method('import')
            ->with($this->dataImporterConfigurationTransferMock)
            ->willReturn($this->dataImporterReportTransferMock);

        $this->assertEquals(
            $this->dataImporterReportTransferMock,
            $this->companyTypeDataImportFacade->importCompanyTypes($this->dataImporterConfigurationTransferMock),
        );
    }
}
