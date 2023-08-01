<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface;

class RandomPasswordGeneratorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Service\CompanyUsersRestApiToUtilTextServiceInterface&\PHPUnit\Framework\MockObject\MockObject|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $utilTextServiceMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Business\Generator\RandomPasswordGenerator
     */
    protected $randomPasswordGenerator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->utilTextServiceMock = $this->getMockBuilder(CompanyUsersRestApiToUtilTextServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->randomPasswordGenerator = new RandomPasswordGenerator(
            $this->utilTextServiceMock,
        );
    }

    /**
     * @return void
     */
    public function testGenerate(): void
    {
        $password = 'fooBarfooBarfooBarfo';

        $this->utilTextServiceMock->expects(static::atLeastOnce())
            ->method('generateRandomString')
            ->with(RandomPasswordGenerator::PASSWORD_LENGTH)
            ->willReturn($password);

        static::assertEquals(
            $password,
            $this->randomPasswordGenerator->generate(),
        );
    }
}
