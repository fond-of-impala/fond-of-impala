<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Plugin\ProductManagement;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Form\AllowedQuantityForm;
use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class AllowedQuantityProductAbstractFormTransferMapperExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityGui\Communication\Plugin\ProductManagement\AllowedQuantityProductAbstractFormTransferMapperExpanderPlugin
     */
    protected $allowedQuantityProductAbstractFormTransferMapperExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected $productAbstractTransferMock;

    /**
     * @var array
     */
    protected $formData;

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
