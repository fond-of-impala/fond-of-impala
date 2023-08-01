<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator;

use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface;

class RestorePasswordKeyGenerator implements RestorePasswordKeyGeneratorInterface
{
    /**
     * @var int
     */
    public const RESTORE_PASSWORD_KEY_LENGTH = 32;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface
     */
    protected $utilTextService;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface $utilTextService
     */
    public function __construct(CompanyUsersRestApiToUtilTextServiceInterface $utilTextService)
    {
        $this->utilTextService = $utilTextService;
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        return $this->utilTextService->generateRandomString(static::RESTORE_PASSWORD_KEY_LENGTH);
    }
}
