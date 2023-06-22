<?php

namespace FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder;

use Codeception\Test\Unit;

class GroupKeyBuilderTest extends Unit
{
    /**
     * @var \FondOfImpala\Service\ConditionalAvailabilityCartConnector\GroupKeyBuilder\GroupKeyBuilder
     */
    protected $groupKeyBuilder;

    /**
     * @var string
     */
    protected $sku;

    /**
     * @var string
     */
    protected $deliveryDate;

    /**
     * @var string
     */
    protected $groupKey;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->sku = 'sku';

        $this->deliveryDate = 'deliver-date';

        $this->groupKey = "{$this->sku}.{$this->deliveryDate}";

        $this->groupKeyBuilder = new GroupKeyBuilder();
    }

    /**
     * @return void
     */
    public function testBuild(): void
    {
        $this->assertSame(
            $this->groupKey,
            $this->groupKeyBuilder->build($this->sku, $this->deliveryDate),
        );
    }
}
