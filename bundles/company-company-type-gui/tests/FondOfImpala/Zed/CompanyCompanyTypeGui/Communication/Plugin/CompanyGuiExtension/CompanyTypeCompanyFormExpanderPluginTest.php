<?php

namespace FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Plugin\CompanyGuiExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\CompanyCompanyTypeGuiCommunicationFactory;
use FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\CompanyCompanyTypeForm;
use FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\DataProvider\CompanyCompanyTypeFormDataProvider;
use ReflectionProperty;
use Symfony\Component\Form\FormBuilderInterface;

class CompanyTypeCompanyFormExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Symfony\Component\Form\FormBuilderInterface
     */
    protected $formBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\CompanyCompanyTypeGuiCommunicationFactory
     */
    protected $companyCompanyTypeGuiCommunicationFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\CompanyCompanyTypeForm
     */
    protected $companyCompanyTypeFormMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\DataProvider\CompanyCompanyTypeFormDataProvider
     */
    protected $companyCompanyTypeFormDataProviderMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Plugin\CompanyGuiExtension\CompanyTypeCompanyFormExpanderPlugin
     */
    protected $companyTypeCompanyFormExpanderPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->formBuilderMock = $this->getMockBuilder(FormBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyCompanyTypeGuiCommunicationFactoryMock = $this->getMockBuilder(CompanyCompanyTypeGuiCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyCompanyTypeFormMock = $this->getMockBuilder(CompanyCompanyTypeForm::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyCompanyTypeFormDataProviderMock = $this->getMockBuilder(CompanyCompanyTypeFormDataProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeCompanyFormExpanderPlugin = new CompanyTypeCompanyFormExpanderPlugin();

        $factoryProperty = new ReflectionProperty(get_parent_class($this->companyTypeCompanyFormExpanderPlugin), 'factory');
        $factoryProperty->setAccessible(true);
        $factoryProperty->setValue(
            $this->companyTypeCompanyFormExpanderPlugin,
            $this->companyCompanyTypeGuiCommunicationFactoryMock,
        );
    }

    /**
     * @return void
     */
    public function testBuildForm(): void
    {
        $options = [
            CompanyCompanyTypeForm::OPTIONS_COMPANY_TYPE => [
                'Test' => 1,
            ],
        ];

        $this->companyCompanyTypeGuiCommunicationFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyCompanyTypeForm')
            ->willReturn($this->companyCompanyTypeFormMock);

        $this->companyCompanyTypeGuiCommunicationFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyCompanyTypeFormDataProvider')
            ->willReturn($this->companyCompanyTypeFormDataProviderMock);

        $this->companyCompanyTypeFormDataProviderMock->expects($this->atLeastOnce())
            ->method('getOptions')
            ->willReturn($options);

        $this->companyCompanyTypeFormMock->expects($this->atLeastOnce())
            ->method('buildForm')
            ->with($this->formBuilderMock, $options);

        $this->companyTypeCompanyFormExpanderPlugin->buildForm($this->formBuilderMock);
    }
}
