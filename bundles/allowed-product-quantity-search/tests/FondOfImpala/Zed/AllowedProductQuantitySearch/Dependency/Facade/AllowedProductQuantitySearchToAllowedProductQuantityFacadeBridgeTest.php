<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityFacadeInterface;
use Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class AllowedProductQuantitySearchToAllowedProductQuantityFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantitySearch\Dependency\Facade\AllowedProductQuantitySearchToAllowedProductQuantityFacadeBridge
     */
    protected $allowedProductQuantitySearchToAllowedProductQuantityFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityFacadeInterface
     */
    protected $allowedProductQuantityFacadeInterface;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected $productAbstractTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer
     */
    protected $allowedProductQuantityResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedProductQuantityFacadeInterface = $this->getMockBuilder(AllowedProductQuantityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractTransferMock = $this->getMockBuilder(ProductAbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityResponseTransferMock = $this->getMockBuilder(AllowedProductQuantityResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantitySearchToAllowedProductQuantityFacadeBridge = new AllowedProductQuantitySearchToAllowedProductQuantityFacadeBridge(
            $this->allowedProductQuantityFacadeInterface,
        );
    }

    /**
     * @return void
     */
    public function testFindProductAbstractAllowedQuantity(): void
    {
        $this->allowedProductQuantityFacadeInterface->expects($this->atLeastOnce())
            ->method('findProductAbstractAllowedQuantity')
            ->willReturn($this->allowedProductQuantityResponseTransferMock);

        $this->assertInstanceOf(
            AllowedProductQuantityResponseTransfer::class,
            $this->allowedProductQuantitySearchToAllowedProductQuantityFacadeBridge->findProductAbstractAllowedQuantity($this->productAbstractTransferMock),
        );
    }
}
