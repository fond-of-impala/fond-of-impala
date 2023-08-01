<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Service;

use Spryker\Service\UtilText\UtilTextServiceInterface;

class CompanyUsersRestApiToUtilTextServiceBridge implements CompanyUsersRestApiToUtilTextServiceInterface
{
    /**
     * @var \Spryker\Service\UtilText\UtilTextServiceInterface
     */
    protected $utilTextService;

    /**
     * @param \Spryker\Service\UtilText\UtilTextServiceInterface $utilTextService
     */
    public function __construct(UtilTextServiceInterface $utilTextService)
    {
        $this->utilTextService = $utilTextService;
    }

    /**
     * @param int $length
     *
     * @return string
     */
    public function generateRandomString(int $length): string
    {
        return $this->utilTextService->generateRandomString($length);
    }
}
