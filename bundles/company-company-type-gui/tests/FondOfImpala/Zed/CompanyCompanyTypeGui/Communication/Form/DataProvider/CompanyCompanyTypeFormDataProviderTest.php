<?php

namespace FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\DataProvider;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\CompanyCompanyTypeForm;
use FondOfImpala\Zed\CompanyCompanyTypeGui\Dependency\Facade\CompanyCompanyTypeGuiToCompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyCompanyTypeFormDataProviderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\DataProvider\CompanyCompanyTypeFormDataProvider
     */
    protected $companyCompanyTypeFormDataProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyCompanyTypeGui\Dependency\Facade\CompanyCompanyTypeGuiToCompanyTypeFacadeInterface
     */
    protected $companyCompanyTypeGuiToCompanyTypeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    protected $companyTypeCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @var \ArrayObject<\PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer>
     */
    protected $companyTypeTransferMocks;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyCompanyTypeGuiToCompanyTypeFacadeMock = $this->getMockBuilder(CompanyCompanyTypeGuiToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeCollectionTransferMock = $this->getMockBuilder(CompanyTypeCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMocks = new ArrayObject([$this->companyTypeTransferMock]);

        $this->companyCompanyTypeFormDataProvider = new CompanyCompanyTypeFormDataProvider(
            $this->companyCompanyTypeGuiToCompanyTypeFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetOptions(): void
    {
        $this->companyCompanyTypeGuiToCompanyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyTypes')
            ->willReturn($this->companyTypeCollectionTransferMock);

        $this->companyTypeCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyTypes')
            ->willReturn($this->companyTypeTransferMocks);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyType')
            ->willReturn(1);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('Test');

        $options = $this->companyCompanyTypeFormDataProvider->getOptions();

        $this->assertArrayHasKey(CompanyCompanyTypeForm::OPTIONS_COMPANY_TYPE, $options);
        $this->assertArrayHasKey('Test', $options[CompanyCompanyTypeForm::OPTIONS_COMPANY_TYPE]);
        $this->assertEquals(1, $options[CompanyCompanyTypeForm::OPTIONS_COMPANY_TYPE]['Test']);
    }
}
