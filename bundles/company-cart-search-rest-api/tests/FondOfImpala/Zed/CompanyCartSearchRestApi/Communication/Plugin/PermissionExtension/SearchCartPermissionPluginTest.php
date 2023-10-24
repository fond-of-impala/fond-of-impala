<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Communication\Plugin\PermissionExtension;

use Codeception\Test\Unit;

class SearchCartPermissionPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Communication\Plugin\PermissionExtension\SearchCartPermissionPlugin
     */
    protected SearchCartPermissionPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->plugin = new SearchCartPermissionPlugin();
    }

    /**
     * @return void
     */
    public function testGetKey(): void
    {
        static::assertEquals(
            SearchCartPermissionPlugin::KEY,
            $this->plugin->getKey(),
        );
    }
}
