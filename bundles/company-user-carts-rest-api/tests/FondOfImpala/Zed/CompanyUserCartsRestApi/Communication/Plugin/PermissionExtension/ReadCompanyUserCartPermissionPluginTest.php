<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Communication\Plugin\PermissionExtension;

use Codeception\Test\Unit;

class ReadCompanyUserCartPermissionPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\Communication\Plugin\PermissionExtension\ReadCompanyUserCartPermissionPlugin
     */
    protected ReadCompanyUserCartPermissionPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->plugin = new ReadCompanyUserCartPermissionPlugin();
    }

    /**
     * @return void
     */
    public function testGetKey(): void
    {
        static::assertEquals(
            ReadCompanyUserCartPermissionPlugin::KEY,
            $this->plugin->getKey(),
        );
    }
}
