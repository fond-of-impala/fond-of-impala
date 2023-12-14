<?php

namespace FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\Form;

use Spryker\Zed\Gui\Communication\Form\Type\SelectType;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method \FondOfImpala\Zed\CompanyCompanyTypeGui\Communication\CompanyCompanyTypeGuiCommunicationFactory getFactory()
 */
class CompanyCompanyTypeForm extends AbstractType
{
    /**
     * @var string
     */
    public const FIELD_FK_COMPANY_TYPE = 'fk_company_type';

    /**
     * @var string
     */
    public const OPTIONS_COMPANY_TYPE = 'OPTIONS_COMPANY_TYPE';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addCompanyTypeCollectionField($builder, $options);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    protected function addCompanyTypeCollectionField(FormBuilderInterface $builder, array $options)
    {
        $builder->add(static::FIELD_FK_COMPANY_TYPE, SelectType::class, [
            'label' => 'Company Type',
            'choices' => $options[static::OPTIONS_COMPANY_TYPE],
            'required' => false,
        ]);

        return $this;
    }
}
