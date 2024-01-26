<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Business\Model;

use Codeception\Test\Unit;

class AllowedProductQuantitySearchWriterTest extends Unit
{
    protected AllowedProductQuantitySearchWriter $allowedProductQuantitySearchWriter;

    protected array $allowedProductQuantityIds;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedProductQuantityIds = [];

        $this->allowedProductQuantitySearchWriter = new AllowedProductQuantitySearchWriter();
    }

    /**
     * @return void
     */
    public function testPublish(): void
    {
        $this->allowedProductQuantitySearchWriter->publish($this->allowedProductQuantityIds);
    }

    /**
     * @return void
     */
    public function testUnpublish(): void
    {
        $this->allowedProductQuantitySearchWriter->unpublish($this->allowedProductQuantityIds);
    }
}
