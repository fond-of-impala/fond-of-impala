<?php

namespace FondOfImpala\Zed\CompanyType\Business\CompanyTypeExportValidator;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeReaderInterface;
use FondOfImpala\Zed\CompanyType\CompanyTypeConfig;
use FondOfImpala\Zed\CompanyType\Dependency\Facade\CompanyTypeToCompanyBusinessUnitFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\EventEntityTransfer;

class CompanyTypeExportValidatorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeReaderInterface
     */
    protected $companyTypeReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\Dependency\Facade\CompanyTypeToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyType\CompanyTypeConfig
     */
    protected $configMock;

    /**
     * @var \FondOfImpala\Zed\CompanyType\Business\CompanyTypeExportValidator\CompanyTypeExportValidator
     */
    protected $companyTypeExportValidator;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\EventEntityTransfer
     */
    protected $eventEntityTransferMock;

    /**
     * @var array<string>
     */
    protected $validCompanyTypesForExport;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTypeReaderMock = $this->getMockBuilder(CompanyTypeReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitFacadeMock = $this->getMockBuilder(CompanyTypeToCompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeReaderMock = $this->getMockBuilder(CompanyTypeReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventEntityTransferMock = $this->getMockBuilder(EventEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(CompanyTypeConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->validCompanyTypesForExport = ['companyType'];
        $this->companyTypeExportValidator = new CompanyTypeExportValidator(
            $this->companyTypeReaderMock,
            $this->companyBusinessUnitFacadeMock,
            $this->configMock,
        );
    }

    /**
     * @return void
     */
    public function testValidateWithForeignKey(): void
    {
        $foreignKeys = [
            'spy_company_unit_address.fk_company' => 1,
        ];

        $this->eventEntityTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('spy_company_unit_address');

        $this->eventEntityTransferMock->expects($this->atLeastOnce())
            ->method('getForeignKeys')
            ->willReturn($foreignKeys);

        $this->companyTypeReaderMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeByIdCompany')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('companyType');

        $this->configMock->expects($this->atLeastOnce())
            ->method('getValidCompanyTypesForExport')
            ->willReturn($this->validCompanyTypesForExport);

        $isValid = $this->companyTypeExportValidator->validate($this->eventEntityTransferMock);

        $this->isTrue(is_bool($isValid));
        $this->assertEquals(true, $isValid);
    }

    /**
     * @return void
     */
    public function testValidateWithEventEntityType(): void
    {
        $this->eventEntityTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('spy_company_business_unit');

        $this->eventEntityTransferMock->expects($this->atLeastOnce())
            ->method('getForeignKeys')
            ->willReturn([]);

        $this->eventEntityTransferMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn(1);

        $this->companyBusinessUnitFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyBusinessUnitById')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getFkCompany')
            ->willReturn(1);

        $this->companyTypeReaderMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeByIdCompany')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('companyType');

        $this->configMock->expects($this->atLeastOnce())
            ->method('getValidCompanyTypesForExport')
            ->willReturn($this->validCompanyTypesForExport);

         $isValid = $this->companyTypeExportValidator->validate($this->eventEntityTransferMock);

         $this->isTrue(is_bool($isValid));
         $this->assertEquals(true, $isValid);
    }
}
