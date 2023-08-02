<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator;

interface RestorePasswordKeyGeneratorInterface
{
    /**
     * @return string
     */
    public function generate(): string;
}
