<?php

namespace FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Validator;

class UrlValidator implements UrlValidatorInterface
{
    /**
     * @var string
     */
    protected const PROTOCOL = '@^http|https://@i';

    /**
     * @param string $url
     *
     * @return bool
     */
    public function isValid(string $url): bool
    {
        return (preg_match(static::PROTOCOL, $url)) && (filter_var($url, FILTER_VALIDATE_URL) !== false);
    }
}
