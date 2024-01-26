<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Plugin\ProductManagement;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\AllowedQuantityForm;
use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class AllowedQuantityProductAbstractFormTransferMapperExpanderPluginTest extends Unit
{
    protected AllowedQuantityProductAbstractFormTransferMapperExpanderPlugin $allowedQuantityProductAbstractFormTransferMapperExpanderPlugin;

    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

    protected array $formData;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productAbstractTransferMock = $this->getMockBuilder(ProductAbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->formData = [
        AllowedQuantityForm::NAME =>
            (new AllowedProductQuantityTransfer())->setIdAllowedProductQuantity(1)
                ->setIdProductAbstract(1)
                ->setQuantityInterval(1)
                ->setQuantityMax(1)
                ->setQuantityMin(1)
                ->toArray(),
        ];

        $this->allowedQuantityProductAbstractFormTransferMapperExpanderPlugin = new AllowedQuantityProductAbstractFormTransferMapperExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testMap(): void
    {
        $this->productAbstractTransferMock->expects($this->atLeastOnce())
            ->method('setAllowedQuantity')
            ->willReturn($this->productAbstractTransferMock);

        $this->assertInstanceOf(ProductAbstractTransfer::class, $this->allowedQuantityProductAbstractFormTransferMapperExpanderPlugin->map($this->productAbstractTransferMock, $this->formData));
    }
}
