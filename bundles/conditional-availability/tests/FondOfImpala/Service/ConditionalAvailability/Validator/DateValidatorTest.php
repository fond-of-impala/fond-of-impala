<?php

namespace FondOfImpala\Service\ConditionalAvailability\Validator;

use Codeception\Test\Unit;
use DateTime;

class DateValidatorTest extends Unit
{
    protected DateValidator $dateValidator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->dateValidator = new DateValidator();
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $date = new DateTime();
        $date->modify('this monday');

        static::assertTrue($this->dateValidator->validate($date));
    }

    /**
     * @return void
     */
    public function testValidateWithInvalidDate(): void
    {
        $date = new DateTime();
        $date->modify('this saturday');

        static::assertFalse($this->dateValidator->validate($date));
    }
}
