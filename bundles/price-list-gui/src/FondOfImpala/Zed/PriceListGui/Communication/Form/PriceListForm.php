<?php

namespace FondOfImpala\Zed\PriceListGui\Communication\Form;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;

/**
 * @method \FondOfImpala\Zed\PriceListGui\PriceListGuiConfig getConfig()
 * @method \FondOfImpala\Zed\PriceListGui\Communication\PriceListGuiCommunicationFactory getFactory()
 */
class PriceListForm extends AbstractType
{
    /**
     * @var string
     */
    public const FIELD_PRICE_LIST_ID = 'id_price_list';

    /**
     * @var string
     */
    public const FIELD_NAME = 'name';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addPriceListIdField($builder)
            ->addNameField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addPriceListIdField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_PRICE_LIST_ID, HiddenType::class, [
            'label' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addNameField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_NAME, TextType::class, [
            'label' => 'Name',
            'constraints' => [
                new NotBlank(),
                new Required(),
            ],
        ]);

        return $this;
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'price_list';
    }

    /**
     * @deprecated Use `getBlockPrefix()` instead.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getBlockPrefix();
    }
}
