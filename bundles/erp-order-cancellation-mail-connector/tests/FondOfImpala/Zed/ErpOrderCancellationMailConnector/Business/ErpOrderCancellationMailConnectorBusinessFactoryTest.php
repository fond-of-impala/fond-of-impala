<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\Model\Mail\MailHandlerInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToLocaleFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToMailFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\ErpOrderCancellationMailConnectorDependencyProvider;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepository;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Spryker\Shared\Log\Config\LoggerConfigInterface;
use Spryker\Zed\Kernel\Container;

class ErpOrderCancellationMailConnectorBusinessFactoryTest extends Unit
{
    protected MockObject|Container $containerMock;

    protected MockObject|ErpOrderCancellationMailConnectorRepositoryInterface $repositoryMock;

    protected MockObject|ErpOrderCancellationMailConnectorToMailFacadeInterface $mailFacadeMock;

    protected MockObject|ErpOrderCancellationMailConnectorToLocaleFacadeInterface $localeFacadeMock;

    protected MockObject|LoggerInterface $loggerMock;

    protected ErpOrderCancellationMailConnectorBusinessFactory $businessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ErpOrderCancellationMailConnectorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailFacadeMock = $this->getMockBuilder(ErpOrderCancellationMailConnectorToMailFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeFacadeMock = $this->getMockBuilder(ErpOrderCancellationMailConnectorToLocaleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->businessFactory = new class ($this->loggerMock) extends ErpOrderCancellationMailConnectorBusinessFactory {
            /**
             * @var \Psr\Log\LoggerInterface
             */
            protected LoggerInterface $logger;

            /**
             * @param \Psr\Log\LoggerInterface $logger
             */
            public function __construct(LoggerInterface $logger)
            {
                $this->logger = $logger;
            }

            /**
             * @param \Spryker\Shared\Log\Config\LoggerConfigInterface|null $loggerConfig
             *
             * @return \Psr\Log\LoggerInterface
             */
            public function getLogger(?LoggerConfigInterface $loggerConfig = null): LoggerInterface
            {
                return $this->logger;
            }
        };
        $this->businessFactory->setRepository($this->repositoryMock);
        $this->businessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateMailHandler(): void
    {
        $self = $this;
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $callCount = static::atLeastOnce();
        $this->containerMock->expects($callCount)
            ->method('get')
            ->willReturnCallback(
                static function (string $key) use ($self, $callCount) {
                    /** @phpstan-ignore-next-line */
                    if (method_exists($callCount, 'getInvocationCount')) {
                        /** @phpstan-ignore-next-line */
                        $count = $callCount->getInvocationCount();
                    } else {
                        /** @phpstan-ignore-next-line */
                        $count = $callCount->numberOfInvocations();
                    }

                    switch ($count) {
                        case 1:
                            $self->assertEquals(ErpOrderCancellationMailConnectorDependencyProvider::FACADE_MAIL, $key);

                            return $self->mailFacadeMock;
                        case 2:
                            $self->assertEquals(ErpOrderCancellationMailConnectorDependencyProvider::FACADE_LOCALE, $key);

                            return $self->localeFacadeMock;
                    }
                },
            );

        static::assertInstanceOf(
            MailHandlerInterface::class,
            $this->businessFactory->createMailHandler(),
        );
    }
}
