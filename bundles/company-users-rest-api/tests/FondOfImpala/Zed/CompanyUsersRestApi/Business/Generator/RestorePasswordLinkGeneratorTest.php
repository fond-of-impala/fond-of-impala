<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;

class RestorePasswordLinkGeneratorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordLinkGenerator
     */
    protected $restorePasswordLinkGenerator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(CompanyUsersRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restorePasswordLinkGenerator = new RestorePasswordLinkGenerator(
            $this->configMock,
        );
    }

    /**
     * @return void
     */
    public function testGenerate(): void
    {
        $token = 'fooBarfooBarfooBar';
        $restorePasswordLinkFormat = 'http://base.uri/invite/%s';

        $this->configMock->expects(static::atLeastOnce())
            ->method('getRestorePasswordLinkFormat')
            ->willReturn($restorePasswordLinkFormat);

        static::assertEquals(
            sprintf($restorePasswordLinkFormat, $token),
            $this->restorePasswordLinkGenerator->generate($token),
        );
    }
}
