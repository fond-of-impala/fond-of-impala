<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade;

use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CompanyUserCartsRestApiToPermissionFacadeBridge implements CompanyUserCartsRestApiToPermissionFacadeInterface
{
    /**
     * @var \Spryker\Zed\Permission\Business\PermissionFacadeInterface
     */
    protected PermissionFacadeInterface $permissionFacade;

    /**
     * @param \Spryker\Zed\Permission\Business\PermissionFacadeInterface $permissionFacade
     */
    public function __construct(PermissionFacadeInterface $permissionFacade)
    {
        $this->permissionFacade = $permissionFacade;
    }

    /**
     * @param string $permissionKey
     * @param string|int $identifier
     * @param array|string|int|null $context
     *
     * @return bool
     */
    public function can(
        string $permissionKey,
        string|int $identifier,
        array|string|int|null $context = null
    ): bool {
        return $this->permissionFacade->can($permissionKey, $identifier, $context);
    }
}
