<?php

namespace FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Expander;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Validator\UrlValidatorInterface;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Generated\Shared\Transfer\ProductPayloadTransfer;
use Orm\Zed\ProductImage\Persistence\SpyProductImageSet;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\ProductPageSearch\ProductPageSearchConfig;

class ProductImageGroupedPageDataExpanderTest extends Unit
{
    protected ProductImageGroupPageDataExpander $expander;

    protected MockObject|ProductPageSearchTransfer $pageSearchTransferMock;

    protected MockObject|ProductPayloadTransfer $productPayloadTransferMock;

    protected MockObject|SpyProductImageSet $spyProductImageSetMock;

    protected MockObject|UrlValidatorInterface $urlValidatorMock;

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

        $this->urlValidatorMock = $this->getMockBuilder(UrlValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new ProductImageGroupPageDataExpander($this->urlValidatorMock);
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
                    static fn (array $groupedProductImages): bool => array_keys($groupedProductImages) == [$key],
                ),
            )->willReturn($this->pageSearchTransferMock);

        $this->expander->expandProductPageData($productData, $this->pageSearchTransferMock);
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
                    static fn (array $groupedProductImages): bool => array_keys($groupedProductImages) == ['*'],
                ),
            )->willReturn($this->pageSearchTransferMock);

        $this->expander->expandProductPageData($productData, $this->pageSearchTransferMock);
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
                    static fn (array $groupedProductImages): bool => array_keys($groupedProductImages) == ['*'],
                ),
            )->willReturn($this->pageSearchTransferMock);

        $this->expander->expandProductPageData($productData, $this->pageSearchTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandProductPageDataWithUrlValidation(): void
    {
        $self = $this;

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
            'external_url_small' => 'asdas',
            'external_url_large' => 'https://www.fondof.de',
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

        $callCount = $this->atLeastOnce();
        $this->urlValidatorMock->expects($callCount)
            ->method('isValid')
            ->willReturnCallback(static function (string $key) use ($self, $callCount) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        $self->assertSame('asdas', $key);

                        return false;
                    case 2:
                        $self->assertSame('https://www.fondof.de', $key);

                        return true;
                }

                throw new Exception('Unexpected call count');
            });

        $this->pageSearchTransferMock->expects(static::atLeastOnce())
            ->method('setGroupedProductImages')
            ->with(
                [],
            )->willReturn($this->pageSearchTransferMock);

        $this->expander->expandProductPageData($productData, $this->pageSearchTransferMock);
    }
}
