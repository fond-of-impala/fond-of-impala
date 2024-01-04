<?php

namespace FondOfImpala\Zed\ProductManagement\Communication\Form;

use FondOfImpala\Zed\ProductManagement\Communication\Form\Product\Price\ProductMoneyCollectionType;
use Generated\Shared\Transfer\PriceProductTransfer;
use Spryker\Zed\ProductManagement\Communication\Form\Product\Price\ProductMoneyType;
use Spryker\Zed\ProductManagement\Communication\Form\ProductFormEdit as SprykerProductFormEdit;
use Spryker\Zed\ProductManagement\Communication\Form\Validator\Constraints\ProductPriceNotBlank;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method \Spryker\Zed\ProductManagement\ProductManagementConfig getConfig()
 * @method \Spryker\Zed\ProductManagement\Persistence\ProductManagementQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\ProductManagement\Persistence\ProductManagementRepositoryInterface getRepository()
 * @method \Spryker\Zed\ProductManagement\Business\ProductManagementFacadeInterface getFacade()
 * @method \Spryker\Zed\ProductManagement\Communication\ProductManagementCommunicationFactory getFactory()
 */
class ProductFormEdit extends SprykerProductFormEdit
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return \Spryker\Zed\ProductManagement\Communication\Form\ProductFormAdd
     */
    protected function addPriceForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder->add(
            static::FIELD_PRICES,
            ProductMoneyCollectionType::class,
            [
                'entry_options' => [
                    'data_class' => PriceProductTransfer::class,
                ],
                'entry_type' => ProductMoneyType::class,
                'constraints' => [
                    new ProductPriceNotBlank([
                        'groups' => [static::VALIDATION_GROUP_PRICE_SOURCE],
                    ]),
                ],
            ],
        );

        return $this;
    }
}
