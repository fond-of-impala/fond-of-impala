<?php
namespace FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Communication\Plugin\ProductPageSearch;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Generated\Shared\Transfer\ProductPayloadTransfer;
use Orm\Zed\ProductImage\Persistence\SpyProductImageSet;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\ProductPageSearch\ProductPageSearchConfig;

class ProductImageGroupedPageDataLoaderExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Communication\Plugin\ProductPageSearch\ProductImageGroupedPageDataLoaderExpanderPlugin
     */
    protected ProductImageGroupedPageDataLoaderExpanderPlugin $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductPageSearchTransfer
     */
    protected MockObject|ProductPageSearchTransfer $pageSearchTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductPayloadTransfer
     */
    protected MockObject|ProductPayloadTransfer $productPayloadTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\ProductImage\Persistence\SpyProductImageSet
     */
    protected MockObject|SpyProductImageSet $spyProductImageSetMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->pageSearchTransferMock = $this->getMockBuilder(ProductPageSearchTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productPayloadTransferMock = $this->getMockBuilder(ProductPayloadTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spyProductImageSetMock = $this->getMockBuilder(SpyProductImageSet::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductImageGroupedPageDataLoaderExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandProductPageData(): void
    {
        $key = 'front';
        $idProductImageSet = 44;

        $productData = [
            ProductPageSearchConfig::PRODUCT_ABSTRACT_PAGE_LOAD_DATA => $this->productPayloadTransferMock,
            'fk_locale' => 1,
        ];

        $imageSets = [
            1 => [$this->spyProductImageSetMock],
        ];

        $productImage = [
            'fk_product_image_set' => $idProductImageSet,
        ];

        $this->productPayloadTransferMock->expects(static::atLeastOnce())
            ->method('getImages')
            ->willReturn($imageSets);

        $this->pageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getProductImages')
            ->willReturn([$productImage]);

        $this->spyProductImageSetMock->expects(static::atLeastOnce())
            ->method('getIdProductImageSet')
            ->willReturn($idProductImageSet);

        $this->spyProductImageSetMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($key);

        $this->pageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setGroupedProductImages')
            ->with(
                static::callback(
                    static fn (array $groupedProductImages): bool => array_keys($groupedProductImages) == [$key]
                ),
            )->willReturn($this->pageSearchTransferMock);

        $this->plugin->expandProductPageData($productData, $this->pageSearchTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandProductPageDataWithEmptyImageSetName(): void
    {
        $key = '';
        $idProductImageSet = 44;

        $productData = [
            ProductPageSearchConfig::PRODUCT_ABSTRACT_PAGE_LOAD_DATA => $this->productPayloadTransferMock,
            'fk_locale' => 1,
        ];

        $imageSets = [
            1 => [$this->spyProductImageSetMock],
        ];

        $productImage = [
            'fk_product_image_set' => $idProductImageSet,
        ];

        $this->productPayloadTransferMock->expects(static::atLeastOnce())
            ->method('getImages')
            ->willReturn($imageSets);

        $this->pageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getProductImages')
            ->willReturn([$productImage]);

        $this->spyProductImageSetMock->expects(static::atLeastOnce())
            ->method('getIdProductImageSet')
            ->willReturn($idProductImageSet);

        $this->spyProductImageSetMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($key);

        $this->pageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setGroupedProductImages')
            ->with(
                static::callback(
                    static fn (array $groupedProductImages): bool => array_keys($groupedProductImages) == ['*']
                ),
            )->willReturn($this->pageSearchTransferMock);

        $this->plugin->expandProductPageData($productData, $this->pageSearchTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandProductPageDataWithNullableImageSetName(): void
    {
        $key = null;
        $idProductImageSet = 44;

        $productData = [
            ProductPageSearchConfig::PRODUCT_ABSTRACT_PAGE_LOAD_DATA => $this->productPayloadTransferMock,
            'fk_locale' => 1,
        ];

        $imageSets = [
            1 => [$this->spyProductImageSetMock],
        ];

        $productImage = [
            'fk_product_image_set' => $idProductImageSet,
        ];

        $this->productPayloadTransferMock->expects(static::atLeastOnce())
            ->method('getImages')
            ->willReturn($imageSets);

        $this->pageSearchTransferMock->expects(static::atLeastOnce())
            ->method('getProductImages')
            ->willReturn([$productImage]);

        $this->spyProductImageSetMock->expects(static::atLeastOnce())
            ->method('getIdProductImageSet')
            ->willReturn($idProductImageSet);

        $this->spyProductImageSetMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn($key);

        $this->pageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setGroupedProductImages')
            ->with(
                static::callback(
                    static fn (array $groupedProductImages): bool => array_keys($groupedProductImages) == ['*']
                ),
            )->willReturn($this->pageSearchTransferMock);

        $this->plugin->expandProductPageData($productData, $this->pageSearchTransferMock);
    }
}
