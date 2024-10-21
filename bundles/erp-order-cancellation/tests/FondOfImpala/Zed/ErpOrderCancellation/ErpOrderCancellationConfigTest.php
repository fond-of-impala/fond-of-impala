<?php

namespace FondOfImpala\Zed\ErpOrderCancellation;

use Codeception\Test\Unit;

class ErpOrderCancellationConfigTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\ErpOrderCancellationConfig
     */
    protected ErpOrderCancellationConfig $config;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->config = new ErpOrderCancellationConfig();
    }

    /**
     * @return void
     */
    public function testGetPrefixToReplace(): void
    {
        static::assertIsString($this->config->getPrefixToReplace());
    }

    /**
     * @return void
     */
    public function testGetPrefix(): void
    {
        static::assertIsString($this->config->getPrefix());
    }
}
