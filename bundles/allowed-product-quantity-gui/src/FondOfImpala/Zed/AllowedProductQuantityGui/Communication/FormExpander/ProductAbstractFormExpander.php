<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\FormExpander;

use FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\AllowedQuantityForm;
use FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\DataProvider\AllowedQuantityFormDataProvider;
use Symfony\Component\Form\FormBuilderInterface;

class ProductAbstractFormExpander implements ProductAbstractFormExpanderInterface
{
    protected AllowedQuantityForm $allowedQuantityForm;

    protected AllowedQuantityFormDataProvider $allowedQuantityFormDataProvider;

    /**
     * @param \FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\AllowedQuantityForm $allowedQuantityForm
     * @param \FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\DataProvider\AllowedQuantityFormDataProvider $allowedQuantityFormDataProvider
     */
    public function __construct(
        AllowedQuantityForm $allowedQuantityForm,
        AllowedQuantityFormDataProvider $allowedQuantityFormDataProvider
    ) {
        $this->allowedQuantityForm = $allowedQuantityForm;
        $this->allowedQuantityFormDataProvider = $allowedQuantityFormDataProvider;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    public function expand(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        $idProductAbstract = null;

        if (array_key_exists('data', $options) && array_key_exists('id_product_abstract', $options['data'])) {
            $idProductAbstract = (int)$options['data']['id_product_abstract'];
        }

        $builder->add(AllowedQuantityForm::NAME, AllowedQuantityForm::class, [
            'label' => false,
            'data' => $this->allowedQuantityFormDataProvider->getOptions($idProductAbstract),
        ]);

        //$builder->get(AllowedQuantityForm::NAME)->setData()

        return $builder;
    }
}
