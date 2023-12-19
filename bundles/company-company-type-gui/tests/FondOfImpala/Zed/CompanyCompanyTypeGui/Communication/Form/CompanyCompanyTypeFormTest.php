<?php

namespace FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form;

use Codeception\Test\Unit;
use Spryker\Zed\Gui\Communication\Form\Type\SelectType;
use Symfony\Component\Form\FormBuilderInterface;

class CompanyCompanyTypeFormTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Symfony\Component\Form\FormBuilderInterface
     */
    protected $formBuilderMock;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var \FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form\CompanyCompanyTypeForm
     */
    protected $companyCompanyTypeForm;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->formBuilderMock = $this->getMockBuilder(FormBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->options = [
            CompanyCompanyTypeForm::OPTIONS_COMPANY_TYPE => [
                'Test' => 1,
            ],
        ];

        $this->companyCompanyTypeForm = new CompanyCompanyTypeForm();
    }

    /**
     * @return void
     */
    public function testBuildForm(): void
    {
        $this->formBuilderMock->expects($this->atLeastOnce())
            ->method('add')
            ->with(
                CompanyCompanyTypeForm::FIELD_FK_COMPANY_TYPE,
                SelectType::class,
                [
                    'label' => 'Company Type',
                    'choices' => $this->options[CompanyCompanyTypeForm::OPTIONS_COMPANY_TYPE],
                    'required' => false,
                ],
            )->willReturn($this->formBuilderMock);

        $this->companyCompanyTypeForm->buildForm($this->formBuilderMock, $this->options);
    }
}
