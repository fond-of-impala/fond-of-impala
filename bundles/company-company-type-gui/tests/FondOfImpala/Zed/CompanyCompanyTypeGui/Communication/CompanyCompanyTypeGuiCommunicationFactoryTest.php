<?php

namespace FondOfImpala\Zed\CompanyCompanyTypeGui\Communication;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\CompanyCompanyTypeForm;
use FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\DataProvider\CompanyCompanyTypeFormDataProvider;
use FondOfImpala\Zed\CompanyCompanyTypeGui\CompanyCompanyTypeGuiDependencyProvider;
use FondOfImpala\Zed\CompanyCompanyTypeGui\Dependency\Facade\CompanyCompanyTypeGuiToCompanyTypeFacadeInterface;
use Spryker\Zed\Kernel\Container;

class CompanyCompanyTypeGuiCommunicationFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\CompanyCompanyTypeGuiCommunicationFactory
     */
    protected $companyCompanyTypeGuiCommunicationFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyCompanyTypeGui\Dependency\Facade\CompanyCompanyTypeGuiToCompanyTypeFacadeInterface
     */
    protected $companyCompanyTypeGuiToCompanyTypeFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyCompanyTypeGuiToCompanyTypeFacadeMock = $this->getMockBuilder(CompanyCompanyTypeGuiToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyCompanyTypeGuiCommunicationFactory = new CompanyCompanyTypeGuiCommunicationFactory();

        $this->companyCompanyTypeGuiCommunicationFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyCompanyTypeFormDataProvider(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->with(CompanyCompanyTypeGuiDependencyProvider::FACADE_COMPANY_TYPE)
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(CompanyCompanyTypeGuiDependencyProvider::FACADE_COMPANY_TYPE)
            ->willReturn($this->companyCompanyTypeGuiToCompanyTypeFacadeMock);

        $companyCompanyTypeFormDataProvider = $this->companyCompanyTypeGuiCommunicationFactory
            ->createCompanyCompanyTypeFormDataProvider();

        $this->assertInstanceOf(CompanyCompanyTypeFormDataProvider::class, $companyCompanyTypeFormDataProvider);
    }

    /**
     * @return void
     */
    public function testCreateCompanyCompanyTypeForm(): void
    {
        $companyCompanyTypeForm = $this->companyCompanyTypeGuiCommunicationFactory
            ->createCompanyCompanyTypeForm();

        $this->assertInstanceOf(CompanyCompanyTypeForm::class, $companyCompanyTypeForm);
    }
}
