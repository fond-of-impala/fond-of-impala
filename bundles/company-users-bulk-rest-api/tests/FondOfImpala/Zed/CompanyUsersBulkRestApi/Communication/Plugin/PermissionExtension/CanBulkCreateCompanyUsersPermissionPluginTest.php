<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\PermissionExtension;

use Codeception\Test\Unit;

class CanBulkCreateCompanyUsersPermissionPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\PermissionExtension\CanBulkCreateCompanyUsersPermissionPlugin
     */
    protected CanBulkCreateCompanyUsersPermissionPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->plugin = new CanBulkCreateCompanyUsersPermissionPlugin();
    }

    /**
     * @return void
     */
    public function testGetKey(): void
    {
        static::assertSame($this->plugin->getKey(), CanBulkCreateCompanyUsersPermissionPlugin::KEY);
    }
}
