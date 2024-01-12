<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantityGui\Communication\AllowedProductQuantityGuiCommunicationFactory getFactory()
 */
class AllowedQuantityForm extends AbstractType
{
    /**
     * @var string
     */
    public const NAME = 'allowed_quantity';

    /**
     * @var string
     */
    public const FIELD_ID_ALLOWED_PRODUCT_QUANTITY = 'id_allowed_product_quantity';

    /**
     * @var string
     */
    public const FIELD_QUANTITY_MIN = 'quantity_min';

    /**
     * @var string
     */
    public const FIELD_QUANTITY_MAX = 'quantity_max';

    /**
     * @var string
     */
    public const FIELD_QUANTITY_INTERVAL = 'quantity_interval';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addIdAllowedProductQuantityField($builder, $options)
            ->addMinQuantityField($builder, $options)
            ->addMaxQuantityField($builder, $options)
            ->addIntervalFiled($builder, $options);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    protected function addMinQuantityField(FormBuilderInterface $builder, array $options)
    {
        $builder->add(self::FIELD_QUANTITY_MIN, IntegerType::class, [
            'required' => false,
            'constraints' => [],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    protected function addMaxQuantityField(FormBuilderInterface $builder, array $options)
    {
        $builder->add(self::FIELD_QUANTITY_MAX, IntegerType::class, [
            'required' => false,
            'constraints' => [],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    protected function addIntervalFiled(FormBuilderInterface $builder, array $options)
    {
        $builder->add(self::FIELD_QUANTITY_INTERVAL, IntegerType::class, [
            'required' => false,
            'constraints' => [],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    protected function addIdAllowedProductQuantityField(FormBuilderInterface $builder, array $options)
    {
        $builder->add(self::FIELD_ID_ALLOWED_PRODUCT_QUANTITY, HiddenType::class, [
            'required' => false,
            'constraints' => [],
            'label' => false,
        ]);

        return $this;
    }
}
