<?php

namespace FondOfImpala\Zed\CompanyCartSearchRestApi\Communication\Plugin\PermissionExtension;

use Codeception\Test\Unit;

class SeeAllCompanyQuotesPermissionPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyCartSearchRestApi\Communication\Plugin\PermissionExtension\SeeAllCompanyQuotesPermissionPlugin
     */
    protected SeeAllCompanyQuotesPermissionPlugin $seeAllCompanyQuotesPermissionPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->seeAllCompanyQuotesPermissionPlugin = new SeeAllCompanyQuotesPermissionPlugin();
    }

    /**
     * @return void
     */
    public function testGetKey(): void
    {
        static::assertEquals(
            SeeAllCompanyQuotesPermissionPlugin::KEY,
            $this->seeAllCompanyQuotesPermissionPlugin->getKey(),
        );
    }
}
