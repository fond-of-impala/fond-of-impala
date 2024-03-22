<?php

namespace FondOfImpala\Zed\ProductGroupHash\Communication\Plugin\ProductPageSearchExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;

class GroupHashProductAbstractMapExpanderPluginTest extends Unit
{
    protected MockObject|PageMapTransfer $pageMapTransferMock;

    protected PageMapBuilderInterface|MockObject $pageMapBuilderMock;

    protected MockObject|LocaleTransfer $localeTransferMock;

    protected GroupHashProductAbstractMapExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->pageMapTransferMock = $this->getMockBuilder(PageMapTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pageMapBuilderMock = $this->getMockBuilder(PageMapBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeTransferMock = $this->getMockBuilder(LocaleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new GroupHashProductAbstractMapExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpandProductMap(): void
    {
        $productData = [
            GroupHashProductAbstractMapExpanderPlugin::KEY_GROUP_HASH => sha1('foo'),
        ];

        $this->pageMapTransferMock->expects(static::atLeastOnce())
            ->method('setGroupHash')
            ->with($productData[GroupHashProductAbstractMapExpanderPlugin::KEY_GROUP_HASH])
            ->willReturn($this->pageMapTransferMock);

        static::assertEquals(
            $this->pageMapTransferMock,
            $this->plugin->expandProductMap(
                $this->pageMapTransferMock,
                $this->pageMapBuilderMock,
                $productData,
                $this->localeTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandProductMapWithoutGroupHash(): void
    {
        $productData = [];

        $this->pageMapTransferMock->expects(static::never())
            ->method('setGroupHash');

        static::assertEquals(
            $this->pageMapTransferMock,
            $this->plugin->expandProductMap(
                $this->pageMapTransferMock,
                $this->pageMapBuilderMock,
                $productData,
                $this->localeTransferMock,
            ),
        );
    }
}
