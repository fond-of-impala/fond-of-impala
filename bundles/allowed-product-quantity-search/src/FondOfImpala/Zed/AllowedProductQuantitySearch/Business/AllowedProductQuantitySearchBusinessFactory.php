<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Business;

use FondOfImpala\Zed\AllowedProductQuantitySearch\Business\Model\AllowedProductQuantitySearchWriter;
use FondOfImpala\Zed\AllowedProductQuantitySearch\Business\Model\AllowedProductQuantitySearchWriterInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantitySearch\AllowedProductQuantitySearchConfig getConfig()
 */
class AllowedProductQuantitySearchBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\AllowedProductQuantitySearch\Business\Model\AllowedProductQuantitySearchWriterInterface
     */
    public function createAllowedProductQuantitySearchWriter(): AllowedProductQuantitySearchWriterInterface
    {
        return new AllowedProductQuantitySearchWriter();
    }
}
