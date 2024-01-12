<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Communication\Plugin\PermissionExtension;

use Codeception\Test\Unit;

class WriteCompanyUserCartPermissionPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Communication\Plugin\PermissionExtension\WriteCompanyUserCartPermissionPlugin
     */
    protected WriteCompanyUserCartPermissionPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->plugin = new WriteCompanyUserCartPermissionPlugin();
    }

    /**
     * @return void
     */
    public function testGetKey(): void
    {
        static::assertEquals(
            WriteCompanyUserCartPermissionPlugin::KEY,
            $this->plugin->getKey(),
        );
    }
}
