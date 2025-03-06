<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class ErpOrderCancellationRestApiToPermissionFacadeBridge implements ErpOrderCancellationRestApiToPermissionFacadeInterface
{
    /**
     * @var \Spryker\Zed\Permission\Business\PermissionFacadeInterface;
     */
    protected PermissionFacadeInterface $permissionFacade;

    /**
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     */
    public function __construct(PermissionFacadeInterface $permissionFacade)
    {
        $this->permissionFacade = $permissionFacade;
    }

    /**
     * @param string $permissionKey
     * @param string $identifier
     *
     * @return bool
     */
    public function can(string $permissionKey, string $identifier): bool
    {
        return $this->permissionFacade->can($permissionKey, $identifier);
    }
}
