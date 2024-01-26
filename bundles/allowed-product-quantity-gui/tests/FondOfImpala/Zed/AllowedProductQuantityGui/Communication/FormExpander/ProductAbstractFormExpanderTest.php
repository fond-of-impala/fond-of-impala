<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\FormExpander;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\AllowedQuantityForm;
use FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\DataProvider\AllowedQuantityFormDataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Form\FormBuilderInterface;

class ProductAbstractFormExpanderTest extends Unit
{
    protected ProductAbstractFormExpander $productAbstractFormExpander;

    protected MockObject|AllowedQuantityForm $allowedQuantityFormMock;

    protected MockObject|AllowedQuantityFormDataProvider $allowedQuantityFormDataProviderMock;

    protected MockObject|FormBuilderInterface $formBuilderInterfaceMock;

    protected array $options;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedQuantityFormMock = $this->getMockBuilder(AllowedQuantityForm::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedQuantityFormDataProviderMock = $this->getMockBuilder(AllowedQuantityFormDataProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->formBuilderInterfaceMock = $this->getMockBuilder(FormBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->options = ['data' => ['id_product_abstract' => 1]];

        $this->productAbstractFormExpander = new ProductAbstractFormExpander($this->allowedQuantityFormMock, $this->allowedQuantityFormDataProviderMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->assertInstanceOf(FormBuilderInterface::class, $this->productAbstractFormExpander->expand($this->formBuilderInterfaceMock, $this->options));
    }
}
