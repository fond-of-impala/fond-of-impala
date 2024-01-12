<?php

namespace FondOfImpala\Zed\AllowedProductQuantityGui\Communication\TabExpander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\TabsViewTransfer;

class ProductAbstractTabExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityGui\Communication\TabExpander\ProductAbstractTabExpander
     */
    protected $productAbstractTabExpander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\TabsViewTransfer
     */
    protected $tabsViewTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->tabsViewTransferMock = $this->getMockBuilder(TabsViewTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractTabExpander = new ProductAbstractTabExpander();
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->assertInstanceOf(TabsViewTransfer::class, $this->productAbstractTabExpander->expand($this->tabsViewTransferMock));
    }
}
