<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Form\FormBuilderInterface;

class AllowedQuantityFormTest extends Unit
{
    protected AllowedQuantityForm $allowedQuantityForm;

    protected MockObject|FormBuilderInterface $formBuilderInterfaceMock;

    protected array $options;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->formBuilderInterfaceMock = $this->getMockBuilder(FormBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->options = [];

        $this->allowedQuantityForm = new AllowedQuantityForm();
    }

    /**
     * @return void
     */
    public function testBuildForm(): void
    {
        $this->allowedQuantityForm->buildForm($this->formBuilderInterfaceMock, $this->options);
    }
}
