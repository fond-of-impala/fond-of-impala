<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension;

use Codeception\Test\Unit;

class WriteCompanyUserPermissionPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\WriteCompanyUserPermissionPlugin
     */
    protected $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->plugin = new WriteCompanyUserPermissionPlugin();
    }

    /**
     * @return void
     */
    public function testGetKey(): void
    {
        static::assertEquals(
            WriteCompanyUserPermissionPlugin::KEY,
            $this->plugin->getKey(),
        );
    }
}
