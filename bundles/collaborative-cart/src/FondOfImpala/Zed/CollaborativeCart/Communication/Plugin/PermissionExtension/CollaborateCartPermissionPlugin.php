<?php

namespace FondOfImpala\Zed\CollaborativeCart\Communication\Plugin\PermissionExtension;

use Spryker\Shared\PermissionExtension\Dependency\Plugin\PermissionPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CollaborativeCart\CollaborativeCartConfig getConfig()
 * @method \FondOfImpala\Zed\CollaborativeCart\Business\CollaborativeCartFacadeInterface getFacade()
 */
class CollaborateCartPermissionPlugin extends AbstractPlugin implements PermissionPluginInterface
{
    /**
     * @var string
     */
    public const KEY = 'CanCollaborateCartPermissionPlugin';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getKey(): string
    {
        return static::KEY;
    }
}
