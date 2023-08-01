<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension;

use Codeception\Test\Unit;

class DeleteCompanyUserPermissionPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Communication\Plugin\PermissionExtension\DeleteCompanyUserPermissionPlugin
     */
    protected $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->plugin = new DeleteCompanyUserPermissionPlugin();
    }

    /**
     * @return void
     */
    public function testGetKey(): void
    {
        static::assertEquals(
            DeleteCompanyUserPermissionPlugin::KEY,
            $this->plugin->getKey(),
        );
    }
}
