<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface;

class RestorePasswordKeyGeneratorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $utilTextServiceMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RestorePasswordKeyGenerator
     */
    protected $restorePasswordKeyGenerator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->utilTextServiceMock = $this->getMockBuilder(CompanyUsersRestApiToUtilTextServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restorePasswordKeyGenerator = new RestorePasswordKeyGenerator(
            $this->utilTextServiceMock,
        );
    }

    /**
     * @return void
     */
    public function testGenerate(): void
    {
        $password = 'fooBarfooBarfooBarfooBarfooBarfo';

        $this->utilTextServiceMock->expects(static::atLeastOnce())
            ->method('generateRandomString')
            ->with(RestorePasswordKeyGenerator::RESTORE_PASSWORD_KEY_LENGTH)
            ->willReturn($password);

        static::assertEquals(
            $password,
            $this->restorePasswordKeyGenerator->generate(),
        );
    }
}
