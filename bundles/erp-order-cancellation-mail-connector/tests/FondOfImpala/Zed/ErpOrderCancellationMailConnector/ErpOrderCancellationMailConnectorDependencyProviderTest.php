<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToLocaleFacadeBridge;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToMailFacadeBridge;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;
use Spryker\Zed\Locale\Business\LocaleFacadeInterface;
use Spryker\Zed\Mail\Business\MailFacadeInterface;

class ErpOrderCancellationMailConnectorDependencyProviderTest extends Unit
{
    protected MockObject|BundleProxy $bundleProxyMock;

    protected MockObject|Container $containerMock;

    protected MockObject|LocaleFacadeInterface $localeFacadeMock;

    protected MockObject|MailFacadeInterface $mailFacadeMock;

    protected MockObject|Locator $locatorMock;

    protected ErpOrderCancellationMailConnectorDependencyProvider $dependencyProvider;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $containerMock = $this->getMockBuilder(Container::class);

        if (method_exists($containerMock, 'setMethodsExcept')) {
            $containerMock->setMethodsExcept(['factory', 'set', 'offsetSet', 'get', 'offsetGet']);
        } else {
            $containerMock->onlyMethods(['getLocator'])->enableOriginalClone();
        }

        $this->containerMock = $containerMock->getMock();

        $this->locatorMock = $this->getMockBuilder(Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bundleProxyMock = $this->getMockBuilder(BundleProxy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeFacadeMock = $this->getMockBuilder(LocaleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailFacadeMock = $this->getMockBuilder(MailFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dependencyProvider = new ErpOrderCancellationMailConnectorDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $self = $this;
        $this->containerMock->expects(static::atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects(static::atLeastOnce())
            ->method('__call')
            ->willReturnCallback(static function (string $key) use ($self) {
                switch ($key) {
                    case 'locale':
                        return $self->bundleProxyMock;
                    case 'mail':
                        return $self->bundleProxyMock;
                }

                throw new Exception('Invalid key');
            });

        $this->bundleProxyMock->expects(static::atLeastOnce())
            ->method('__call')
            ->with('facade')
            ->willReturnOnConsecutiveCalls(
                $this->mailFacadeMock,
                $this->localeFacadeMock,
            );

        $container = $this->dependencyProvider
            ->provideBusinessLayerDependencies($this->containerMock);

        static::assertEquals($this->containerMock, $container);

        self::assertInstanceOf(
            ErpOrderCancellationMailConnectorToMailFacadeBridge::class,
            $container[ErpOrderCancellationMailConnectorDependencyProvider::FACADE_MAIL],
        );

        self::assertInstanceOf(
            ErpOrderCancellationMailConnectorToLocaleFacadeBridge::class,
            $container[ErpOrderCancellationMailConnectorDependencyProvider::FACADE_LOCALE],
        );
    }

    /**
     * @return void
     */
    public function testProvidePersistenceLayerDependencies(): void
    {
        $container = $this->dependencyProvider
            ->providePersistenceLayerDependencies($this->containerMock);

        static::assertEquals($this->containerMock, $container);

        self::assertInstanceOf(
            SpyCompanyQuery::class,
            $container[ErpOrderCancellationMailConnectorDependencyProvider::PROPEL_QUERY_COMPANY],
        );

        self::assertInstanceOf(
            SpyCompanyRoleQuery::class,
            $container[ErpOrderCancellationMailConnectorDependencyProvider::PROPEL_QUERY_COMPANY_ROLE],
        );

        self::assertInstanceOf(
            SpyCustomerQuery::class,
            $container[ErpOrderCancellationMailConnectorDependencyProvider::PROPEL_QUERY_CUSTOMER],
        );
    }
}
