<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator;

interface RandomPasswordGeneratorInterface
{
    /**
     * @return string
     */
    public function generate(): string;
}
