<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Plugin\ProductManagementExtension;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductManagementExtension\Dependency\Plugin\ProductAbstractFormExpanderPluginInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantityGui\Communication\AllowedProductQuantityGuiCommunicationFactory getFactory()
 */
class AllowedQuantityProductAbstractFormExpanderPlugin extends AbstractPlugin implements ProductAbstractFormExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api

     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    public function expand(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        return $this->getFactory()->createProductAbstractFormExpander()->expand($builder, $options);
    }
}
