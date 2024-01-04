<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Communication\Plugin\Product;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityFacade;
use Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer;
use Generated\Shared\Transfer\AllowedProductQuantityTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class AllowedQuantityProductAbstractReadPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantity\Communication\Plugin\Product\AllowedQuantityProductAbstractReadPlugin
     */
    protected $allowedQuantityProductAbstractReadPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantity\Business\AllowedProductQuantityFacade
     */
    protected $allowedProductQuantityFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected $productAbstractTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\AllowedProductQuantityResponseTransfer
     */
    protected $allowedProductQuantityResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\AllowedProductQuantityTransfer
     */
    protected $allowedProductQuantityTransferMock;

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

        $this->allowedProductQuantityResponseTransferMock = $this->getMockBuilder(AllowedProductQuantityResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityTransferMock = $this->getMockBuilder(AllowedProductQuantityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedQuantityProductAbstractReadPlugin = new AllowedQuantityProductAbstractReadPlugin();
        $this->allowedQuantityProductAbstractReadPlugin->setFacade($this->allowedProductQuantityFacadeMock);
    }

    /**
     * @return void
     */
    public function testRead(): void
    {
        $this->allowedProductQuantityFacadeMock->expects($this->atLeastOnce())
            ->method('findProductAbstractAllowedQuantity')
            ->willReturn($this->allowedProductQuantityResponseTransferMock);

        $this->allowedProductQuantityResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->allowedProductQuantityResponseTransferMock->expects($this->atLeastOnce())
            ->method('getAllowedProductQuantityTransfer')
            ->willReturn($this->allowedProductQuantityTransferMock);

        $this->productAbstractTransferMock->expects($this->atLeastOnce())
            ->method('setAllowedQuantity')
            ->willReturn($this->productAbstractTransferMock);

        $this->assertInstanceOf(ProductAbstractTransfer::class, $this->allowedQuantityProductAbstractReadPlugin->read($this->productAbstractTransferMock));
    }

    /**
     * @return void
     */
    public function testReadIsNotSuccessful(): void
    {
        $this->allowedProductQuantityFacadeMock->expects($this->atLeastOnce())
            ->method('findProductAbstractAllowedQuantity')
            ->willReturn($this->allowedProductQuantityResponseTransferMock);

        $this->allowedProductQuantityResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->assertInstanceOf(ProductAbstractTransfer::class, $this->allowedQuantityProductAbstractReadPlugin->read($this->productAbstractTransferMock));
    }
}
