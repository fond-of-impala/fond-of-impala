<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business\Generator;

interface CompanyUserReferenceGeneratorInterface
{
    /**
     * @return string
     */
    public function generate(): string;
}
