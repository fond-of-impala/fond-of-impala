<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator;

use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface;

class RandomPasswordGenerator implements RandomPasswordGeneratorInterface
{
    /**
     * @var int
     */
    public const PASSWORD_LENGTH = 20;

    protected CompanyUsersRestApiToUtilTextServiceInterface $utilTextService;

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
        return $this->utilTextService->generateRandomString(static::PASSWORD_LENGTH);
    }
}
