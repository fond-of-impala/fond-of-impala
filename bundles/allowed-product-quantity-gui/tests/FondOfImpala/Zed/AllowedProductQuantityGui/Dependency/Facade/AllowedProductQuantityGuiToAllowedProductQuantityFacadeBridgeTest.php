<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityFacadeInterface;
use Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class AllowedProductQuantityGuiToAllowedProductQuantityFacadeBridgeTest extends Unit
{
    protected AllowedProductQuantityGuiToAllowedProductQuantityFacadeBridge $allowedProductQuantityGuiToAllowedProductQuantityFacadeBridge;

    protected MockObject|AllowedProductQuantityFacadeInterface $allowedProductQuantityFacadeInterfaceMock;

    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedProductQuantityFacadeInterfaceMock = $this->getMockBuilder(AllowedProductQuantityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractTransferMock = $this->getMockBuilder(ProductAbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityGuiToAllowedProductQuantityFacadeBridge = new AllowedProductQuantityGuiToAllowedProductQuantityFacadeBridge(
            $this->allowedProductQuantityFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testFindProductAbstractAllowedQuantity(): void
    {
        $this->assertInstanceOf(
            AllowedProductQuantityResponseTransfer::class,
            $this->allowedProductQuantityGuiToAllowedProductQuantityFacadeBridge->findProductAbstractAllowedQuantity($this->productAbstractTransferMock),
        );
    }
}
