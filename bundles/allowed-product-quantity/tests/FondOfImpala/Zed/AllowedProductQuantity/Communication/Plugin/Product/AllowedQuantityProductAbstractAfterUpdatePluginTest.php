<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Communication\Plugin\Product;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityFacade;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class AllowedQuantityProductAbstractAfterUpdatePluginTest extends Unit
{
    protected AllowedQuantityProductAbstractAfterUpdatePlugin $allowedQuantityProductAbstractAfterUpdatePlugin;

    protected MockObject|AllowedProductQuantityFacade $allowedProductQuantityFacadeMock;

    private MockObject|ProductAbstractTransfer $productAbstractTransferMock;

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

        $this->allowedQuantityProductAbstractAfterUpdatePlugin = new AllowedQuantityProductAbstractAfterUpdatePlugin();
        $this->allowedQuantityProductAbstractAfterUpdatePlugin->setFacade($this->allowedProductQuantityFacadeMock);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->allowedProductQuantityFacadeMock->expects($this->atLeastOnce())
            ->method('persistProductAbstractAllowedQuantity')
            ->willReturn($this->productAbstractTransferMock);

        $this->assertInstanceOf(ProductAbstractTransfer::class, $this->allowedQuantityProductAbstractAfterUpdatePlugin->update($this->productAbstractTransferMock));
    }
}
