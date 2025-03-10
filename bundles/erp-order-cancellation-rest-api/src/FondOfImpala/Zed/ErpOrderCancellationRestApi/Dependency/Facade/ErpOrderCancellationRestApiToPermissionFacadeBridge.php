<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class ErpOrderCancellationRestApiToPermissionFacadeBridge implements ErpOrderCancellationRestApiToPermissionFacadeInterface
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
     * @param int|null $identifier
     *
     * @return bool
     */
    public function can(string $permissionKey, ?int $identifier): bool
    {
        return $this->permissionFacade->can($permissionKey, $identifier);
    }
}
