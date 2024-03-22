<?php

namespace FondOfImpala\Zed\ProductGroupHash\Communication\Plugin\ProductPageSearchExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class GroupHashProductPageDataExpanderPluginTest extends Unit
{
    protected ProductPageSearchTransfer|MockObject $productPageSearchTransferMock;

    protected GroupHashProductPageDataExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productPageSearchTransferMock = $this->getMockBuilder(ProductPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new GroupHashProductPageDataExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandProductPageData(): void
    {
        $productData = [
            'SpyProductAbstract' => [
                'group_hash' => sha1('foo'),
            ],
        ];

        $this->productPageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setGroupHash')
            ->with($productData['SpyProductAbstract']['group_hash'])
            ->willReturn($this->productPageSearchTransferMock);

        $this->plugin->expandProductPageData($productData, $this->productPageSearchTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandProductPageDataWithoutGroupHash(): void
    {
        $productData = [
            'SpyProductAbstract' => [
            ],
        ];

        $this->productPageSearchTransferMock->expects(static::never())
            ->method('setGroupHash');

        $this->plugin->expandProductPageData($productData, $this->productPageSearchTransferMock);
    }
}
