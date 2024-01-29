<?php

namespace FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Validator;

interface UrlValidatorInterface
{
    /**
     * @param string $url
     * @return bool
     */
    public function isValid(string $url): bool;
}
