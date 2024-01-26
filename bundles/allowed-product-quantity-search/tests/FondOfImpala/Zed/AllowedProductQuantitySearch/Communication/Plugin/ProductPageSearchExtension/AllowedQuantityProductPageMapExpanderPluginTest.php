<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Communication\Plugin\ProductPageSearchExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;

class AllowedQuantityProductPageMapExpanderPluginTest extends Unit
{
    protected AllowedQuantityProductPageMapExpanderPlugin $allowedQuantityProductPageMapExpanderPlugin;

    protected MockObject|PageMapTransfer $pageMapTransferMock;

    protected MockObject|PageMapBuilderInterface $pageMapBuilderInterfaceMock;

    protected array $productData;

    protected MockObject|LocaleTransfer $localeTransferMock;

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
    public function testExpandProductMap(): void
    {
        $this->pageMapBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('addSearchResultData')
            ->with($this->pageMapTransferMock, 'allowed_quantity', $this->productData['allowed_quantity'])
            ->willReturn($this->pageMapBuilderInterfaceMock);

        $this->allowedQuantityProductPageMapExpanderPlugin->expandProductMap(
            $this->pageMapTransferMock,
            $this->pageMapBuilderInterfaceMock,
            $this->productData,
            $this->localeTransferMock,
        );
    }
}
