<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension;

use Codeception\Test\Unit;

class UpdateCompanyUserPermissionPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\UpdateCompanyUserPermissionPlugin
     */
    protected $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->plugin = new UpdateCompanyUserPermissionPlugin();
    }

    /**
     * @return void
     */
    public function testGetKey(): void
    {
        static::assertEquals(
            UpdateCompanyUserPermissionPlugin::KEY,
            $this->plugin->getKey(),
        );
    }
}
