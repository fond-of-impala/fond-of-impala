<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator;

use FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;

class RestorePasswordLinkGenerator implements RestorePasswordLinkGeneratorInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig
     */
    protected $config;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig $config
     */
    public function __construct(CompanyUsersRestApiConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $restorePasswordKey
     *
     * @return string
     */
    public function generate(string $restorePasswordKey): string
    {
        return sprintf($this->config->getRestorePasswordLinkFormat(), $restorePasswordKey);
    }
}
