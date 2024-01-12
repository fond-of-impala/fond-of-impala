<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityFacadeInterface;
use Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class AllowedProductQuantityGuiToAllowedProductQuantityFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityGui\Dependency\Facade\AllowedProductQuantityGuiToAllowedProductQuantityFacadeBridge
     */
    protected $allowedProductQuantityGuiToAllowedProductQuantityFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityFacadeInterface
     */
    protected $allowedProductQuantityFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected $productAbstractTransferMock;

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
