<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\FormExpander;

use Symfony\Component\Form\FormBuilderInterface;

interface ProductAbstractFormExpanderInterface
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    public function expand(FormBuilderInterface $builder, array $options): FormBuilderInterface;
}
