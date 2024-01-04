<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form;

use Codeception\Test\Unit;
use Symfony\Component\Form\FormBuilderInterface;

class AllowedQuantityFormTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\AllowedQuantityForm
     */
    protected $allowedQuantityForm;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Symfony\Component\Form\FormBuilderInterface
     */
    protected $formBuilderInterfaceMock;

    /**
     * @var array
     */
    protected $options;

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
