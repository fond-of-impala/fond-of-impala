<?php
namespace FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Communication\Plugin\ProductPageSearch;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;

class ProductImageGroupMapExpanderPluginTest extends Unit
{
    protected ProductImageGroupMapExpanderPlugin $plugin;

    protected MockObject|PageMapTransfer $pageMapTransferMock;

    protected MockObject|PageMapBuilderInterface $pageMapBuilderMock;

    protected MockObject|LocaleTransfer $localeTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->pageMapTransferMock = $this->getMockBuilder(PageMapTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pageMapBuilderMock = $this->getMockBuilder(PageMapBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeTransferMock = $this->getMockBuilder(LocaleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductImageGroupMapExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandProductMap(): void
    {
        $productData = [
            ProductImageGroupMapExpanderPlugin::VALUE => [],
        ];

        $this->pageMapBuilderMock->expects(static::atLeastOnce())->method('addSearchResultData');

        $this->plugin->expandProductMap($this->pageMapTransferMock, $this->pageMapBuilderMock, $productData, $this->localeTransferMock);
    }
}
