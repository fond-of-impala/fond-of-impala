<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Communication\Plugin\ProductPageSearch;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface;

class AllowedQuantityProductPageMapExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantitySearch\Communication\Plugin\ProductPageSearch\AllowedQuantityProductPageMapExpanderPlugin
     */
    protected $allowedQuantityProductPageMapExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PageMapTransfer
     */
    protected $pageMapTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Search\Business\Model\Elasticsearch\DataMapper\PageMapBuilderInterface
     */
    protected $pageMapBuilderInterfaceMock;

    /**
     * @var array
     */
    protected $productData;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\LocaleTransfer
     */
    protected $localeTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->pageMapTransferMock = $this->getMockBuilder(PageMapTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pageMapBuilderInterfaceMock = $this->getMockBuilder(PageMapBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productData = [
            'allowed_quantity' => [],
        ];

        $this->localeTransferMock = $this->getMockBuilder(LocaleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedQuantityProductPageMapExpanderPlugin = new AllowedQuantityProductPageMapExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandProductPageMap(): void
    {
        $this->pageMapBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('addSearchResultData')
            ->with($this->pageMapTransferMock, 'allowed_quantity', $this->productData['allowed_quantity'])
            ->willReturn($this->pageMapBuilderInterfaceMock);

        $this->assertInstanceOf(
            PageMapTransfer::class,
            $this->allowedQuantityProductPageMapExpanderPlugin->expandProductPageMap(
                $this->pageMapTransferMock,
                $this->pageMapBuilderInterfaceMock,
                $this->productData,
                $this->localeTransferMock,
            ),
        );
    }
}
