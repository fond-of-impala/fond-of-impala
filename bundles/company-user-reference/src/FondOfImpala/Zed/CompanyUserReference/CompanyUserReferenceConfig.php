<?php

namespace FondOfImpala\Zed\CompanyUserReference;

use Spryker\Shared\SequenceNumber\SequenceNumberConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class CompanyUserReferenceConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getEnvironmentPrefix(): string
    {
        return $this->get(SequenceNumberConstants::ENVIRONMENT_PREFIX, '');
    }
}
