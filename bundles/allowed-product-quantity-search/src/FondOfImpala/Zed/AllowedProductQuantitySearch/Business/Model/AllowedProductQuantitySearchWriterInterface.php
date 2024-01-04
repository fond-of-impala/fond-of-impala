<?php

namespace FondOfImpala\Zed\AllowedProductQuantitySearch\Business\Model;

interface AllowedProductQuantitySearchWriterInterface
{
    /**
     * @param array $allowedProductQuantityIds
     *
     * @return void
     */
    public function publish(array $allowedProductQuantityIds);

    /**
     * @param array $allowedProductQuantityIds
     *
     * @return void
     */
    public function unpublish(array $allowedProductQuantityIds);
}
