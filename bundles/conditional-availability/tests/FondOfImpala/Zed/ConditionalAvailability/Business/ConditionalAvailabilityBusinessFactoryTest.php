<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPeriodsPersister;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityReader;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityWriter;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\GroupedConditionalAvailabilityReader;
use FondOfImpala\Zed\ConditionalAvailability\ConditionalAvailabilityDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManager;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Spryker\Shared\Log\Config\LoggerConfigInterface;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\Kernel\Container&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected Container|MockObject $containerMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepository&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ConditionalAvailabilityRepository $repositoryMock;

    /**
     * @var (\FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManager&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ConditionalAvailabilityEntityManager|MockObject $entityManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Psr\Log\LoggerInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected LoggerInterface|MockObject $loggerMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityBusinessFactory
     */
    protected ConditionalAvailabilityBusinessFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ConditionalAvailabilityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManagerMock = $this->getMockBuilder(ConditionalAvailabilityEntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new class ($this->loggerMock) extends ConditionalAvailabilityBusinessFactory {
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
            protected function getLogger(?LoggerConfigInterface $loggerConfig = null): LoggerInterface
            {
                return $this->logger;
            }
        };
        $this->factory->setContainer($this->containerMock);
        $this->factory->setRepository($this->repositoryMock);
        $this->factory->setEntityManager($this->entityManagerMock);
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityReader(): void
    {
        static::assertInstanceOf(
            ConditionalAvailabilityReader::class,
            $this->factory->createConditionalAvailabilityReader(),
        );
    }

    /**
     * @return void
     */
    public function testCreateGroupedConditionalAvailabilityReader(): void
    {
        static::assertInstanceOf(
            GroupedConditionalAvailabilityReader::class,
            $this->factory->createGroupedConditionalAvailabilityReader(),
        );
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityPeriodsPersister(): void
    {
        static::assertInstanceOf(
            ConditionalAvailabilityPeriodsPersister::class,
            $this->factory->createConditionalAvailabilityPeriodsPersister(),
        );
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityWriter(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(ConditionalAvailabilityDependencyProvider::PLUGINS_CONDITIONAL_AVAILABILITY_POST_SAVE)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityDependencyProvider::PLUGINS_CONDITIONAL_AVAILABILITY_POST_SAVE)
            ->willReturn([]);

        static::assertInstanceOf(
            ConditionalAvailabilityWriter::class,
            $this->factory->createConditionalAvailabilityWriter(),
        );
    }
}
