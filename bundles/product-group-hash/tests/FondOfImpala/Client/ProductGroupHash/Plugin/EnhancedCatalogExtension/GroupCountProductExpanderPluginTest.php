<?php

namespace FondOfImpala\Client\ProductGroupHash\Plugin\EnhancedCatalogExtension;

use Codeception\Test\Unit;
use Elastica\Result;
use FondOfImpala\Shared\ProductGroupHash\ProductGroupHashConstants;
use PHPUnit\Framework\MockObject\MockObject;

class GroupCountProductExpanderPluginTest extends Unit
{
    protected MockObject|Result $resultMock;

    protected GroupCountProductExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->resultMock = $this->getMockBuilder(Result::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new GroupCountProductExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $product = [];
        $groupCount = 10;
        $innerHits = [
            ProductGroupHashConstants::INNER_HITS_NAME => [
                'hits' => [
                    'total' => [
                        'value' => $groupCount,
                    ],
                ],
            ],
        ];

        $this->resultMock->expects(static::atLeastOnce())
            ->method('getInnerHits')
            ->willReturn($innerHits);

        $product = $this->plugin->expand($product, $this->resultMock);

        static::assertArrayHasKey('group_count', $product);
        static::assertEquals($groupCount, $product['group_count']);
    }

    /**
     * @return void
     */
    public function testExpandWithoutInnerHits(): void
    {
        $product = [];
        $innerHits = [];

        $this->resultMock->expects(static::atLeastOnce())
            ->method('getInnerHits')
            ->willReturn($innerHits);

        $product = $this->plugin->expand($product, $this->resultMock);

        static::assertArrayNotHasKey('group_count', $product);
    }
}
