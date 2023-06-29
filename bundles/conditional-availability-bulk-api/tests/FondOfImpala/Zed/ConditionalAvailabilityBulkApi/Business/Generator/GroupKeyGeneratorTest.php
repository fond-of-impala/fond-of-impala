<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Generator;

use Codeception\Test\Unit;

class GroupKeyGeneratorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityBulkApi\Business\Generator\GroupKeyGenerator
     */
    protected GroupKeyGenerator $groupKeyGenerator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->groupKeyGenerator = new GroupKeyGenerator();
    }

    /**
     * @return void
     */
    public function testGenerateByApiData(): void
    {
        $apiData = [
            'sku' => 'FOO-1',
            'warehouse_group' => 'FOO',
        ];

        static::assertEquals(
            sha1($apiData['warehouse_group']),
            $this->groupKeyGenerator->generateByApiData($apiData),
        );
    }
}
