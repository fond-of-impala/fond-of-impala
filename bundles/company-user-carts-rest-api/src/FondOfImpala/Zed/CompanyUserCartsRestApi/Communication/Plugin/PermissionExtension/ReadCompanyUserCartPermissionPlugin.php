<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Communication\Plugin\PermissionExtension;

use Spryker\Shared\PermissionExtension\Dependency\Plugin\PermissionPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class ReadCompanyUserCartPermissionPlugin extends AbstractPlugin implements PermissionPluginInterface
{
    /**
     * @var string
     */
    public const KEY = 'ReadCompanyUserCartPermissionPlugin';

    /**
     * @return string
     */
    public function getKey(): string
    {
        return static::KEY;
    }
}
