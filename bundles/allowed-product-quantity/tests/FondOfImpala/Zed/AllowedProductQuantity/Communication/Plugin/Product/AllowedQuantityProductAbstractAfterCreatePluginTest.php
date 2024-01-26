<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Communication\Plugin\Product;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityFacade;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class AllowedQuantityProductAbstractAfterCreatePluginTest extends Unit
{
    protected AllowedQuantityProductAbstractAfterCreatePlugin $allowedQuantityProductAbstractAfterCreatePlugin;

    protected MockObject|AllowedProductQuantityFacade $allowedProductQuantityFacadeMock;

    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedProductQuantityFacadeMock = $this->getMockBuilder(AllowedProductQuantityFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractTransferMock = $this->getMockBuilder(ProductAbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedQuantityProductAbstractAfterCreatePlugin = new AllowedQuantityProductAbstractAfterCreatePlugin();
        $this->allowedQuantityProductAbstractAfterCreatePlugin->setFacade($this->allowedProductQuantityFacadeMock);
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->allowedProductQuantityFacadeMock->expects($this->atLeastOnce())
            ->method('persistProductAbstractAllowedQuantity')
            ->willReturn($this->productAbstractTransferMock);

        $this->assertInstanceOf(ProductAbstractTransfer::class, $this->allowedQuantityProductAbstractAfterCreatePlugin->create($this->productAbstractTransferMock));
    }
}
