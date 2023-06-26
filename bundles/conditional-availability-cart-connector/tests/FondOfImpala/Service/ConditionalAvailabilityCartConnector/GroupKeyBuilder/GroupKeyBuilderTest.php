<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder;

use Codeception\Test\Unit;

class GroupKeyBuilderTest extends Unit
{
    /**
     * @var \FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilder
     */
    protected GroupKeyBuilder $groupKeyBuilder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->groupKeyBuilder = new GroupKeyBuilder();
    }

    /**
     * @return void
     */
    public function testBuild(): void
    {
        $deliveryDate = 'bar';
        $sku = 'foo';
        $groupKey = sprintf('%s.%s', $sku, $deliveryDate);

        static::assertEquals(
            $groupKey,
            $this->groupKeyBuilder->build($sku, $deliveryDate),
        );
    }
}
