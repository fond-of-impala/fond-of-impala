<?php
namespace FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Communication\Plugin\ProductPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\ProductImageGroupingProductPageSearchFacade;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductImageGroupedPageDataLoaderExpanderPluginTest extends Unit
{
    protected ProductImageGroupedPageDataLoaderExpanderPlugin $plugin;

    protected MockObject|ProductPageSearchTransfer $pageSearchTransferMock;

    protected MockObject|ProductImageGroupingProductPageSearchFacade $facadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->pageSearchTransferMock = $this->getMockBuilder(ProductPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(ProductImageGroupingProductPageSearchFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductImageGroupedPageDataLoaderExpanderPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testExpandProductPageData(): void
    {
        $this->plugin->expandProductPageData([], $this->pageSearchTransferMock);
    }
}
