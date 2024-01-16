<?php

namespace FondOfImpala\Zed\CollaborativeCart\Dependency\Facade;

use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CollaborativeCartToPermissionFacadeBridge implements CollaborativeCartToPermissionFacadeInterface
{
    /**
     * @var \Spryker\Zed\Permission\Business\PermissionFacadeInterface
     */
    protected $permissionFacade;

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
    public function can(string $permissionKey, $identifier, $context = null): bool
    {
        return $this->permissionFacade->can($permissionKey, $identifier, $context);
    }
}
