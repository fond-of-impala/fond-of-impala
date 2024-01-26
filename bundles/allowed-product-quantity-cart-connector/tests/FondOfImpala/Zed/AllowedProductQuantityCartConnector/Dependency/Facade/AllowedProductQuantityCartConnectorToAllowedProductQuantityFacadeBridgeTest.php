<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityFacadeInterface;
use Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer;
use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeBridgeTest extends Unit
{
    protected MockObject|AllowedProductQuantityFacadeInterface $facadeMock;

    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

    protected MockObject|AllowedProductQuantityResponseTransfer $allowedProductQuantityResponseTransferMock;

    protected MockObject|AllowedProductQuantityTransfer $allowedProductQuantityTransferMock;

    protected AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(AllowedProductQuantityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractTransferMock = $this->getMockBuilder(ProductAbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityResponseTransferMock = $this->getMockBuilder(AllowedProductQuantityResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityTransferMock = $this->getMockBuilder(AllowedProductQuantityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeBridge($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testFindProductAbstractAllowedQuantity(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('findProductAbstractAllowedQuantity')
            ->with($this->productAbstractTransferMock)
            ->willReturn($this->allowedProductQuantityResponseTransferMock);

        static::assertEquals(
            $this->allowedProductQuantityResponseTransferMock,
            $this->bridge->findProductAbstractAllowedQuantity($this->productAbstractTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFindGroupedProductAbstractAllowedQuantitiesByAbstractSkus(): void
    {
        $abstractSkus = ['FOO-001-001'];
        $allowedProductQuantityTransferMocks = [$abstractSkus[0] => $this->allowedProductQuantityTransferMock];

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('findGroupedProductAbstractAllowedQuantitiesByAbstractSkus')
            ->with($abstractSkus)
            ->willReturn($allowedProductQuantityTransferMocks);

        static::assertEquals(
            $allowedProductQuantityTransferMocks,
            $this->bridge->findGroupedProductAbstractAllowedQuantitiesByAbstractSkus($abstractSkus),
        );
    }
}
