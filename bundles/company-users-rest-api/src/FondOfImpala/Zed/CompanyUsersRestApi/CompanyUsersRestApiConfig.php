<?php

declare(strict_types=1);

namespace FondOfImpala\Zed\CompanyUsersRestApi;

use FondOfImpala\Shared\CompanyUsersRestApi\CompanyUsersRestApiConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;
use function sprintf;

/**
 * @codeCoverageIgnore
 */
class CompanyUsersRestApiConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getRestorePasswordLinkFormat(): string
    {
        return sprintf('%sinvite/%%s', $this->getBaseUri());
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->get(CompanyUsersRestApiConstants::BASE_URI, 'http://127.0.0.1/');
    }

    /**
     * @return array
     */
    public function getProtectedRoles(): array
    {
        return $this->get(CompanyUsersRestApiConstants::PROTECTED_ROLES, CompanyUsersRestApiConstants::PROTECTED_ROLES_DEFAULT);
    }
}
