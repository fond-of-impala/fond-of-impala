<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantitySearch\Business\Model\AllowedProductQuantitySearchWriterInterface;

class AllowedProductQuantitySearchBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantitySearch\Business\AllowedProductQuantitySearchBusinessFactory
     */
    protected $allowedProductQuantitySearchBusinessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->allowedProductQuantitySearchBusinessFactory = new AllowedProductQuantitySearchBusinessFactory();
    }

    /**
     * @return void
     */
    public function testCreateAllowedProductQuantitySearchWriter(): void
    {
        $this->assertInstanceOf(AllowedProductQuantitySearchWriterInterface::class, $this->allowedProductQuantitySearchBusinessFactory->createAllowedProductQuantitySearchWriter());
    }
}
