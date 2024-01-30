<?php
namespace FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Validator;

use Codeception\Test\Unit;

class UrlValidatorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductImageGroupingProductPageSearch\Business\Validator\UrlValidator
     */
    protected UrlValidator $validator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->validator = new UrlValidator();
    }

    /**
     * @return void
     */
    public function testIsValid(): void
    {
        static::assertTrue($this->validator->isValid('http://www.fondof.de'));
        static::assertTrue($this->validator->isValid('https://www.fondof.de'));
    }

    /**
     * @return void
     */
    public function testIsNotValid(): void
    {
        static::assertFalse($this->validator->isValid(''));
        static::assertFalse($this->validator->isValid('www.fondof.de'));
        static::assertFalse($this->validator->isValid('?io=transform:'));
        static::assertFalse($this->validator->isValid('?io=transform:https://'));
    }
}
