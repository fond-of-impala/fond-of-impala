<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\ConditionalAvailability\Business;

use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPeriodsPersister;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPeriodsPersisterInterface;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPluginExecutor;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPluginExecutorInterface;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityReader;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityReaderInterface;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityWriter;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityWriterInterface;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\GroupedConditionalAvailabilityReader;
use FondOfImpala\Zed\ConditionalAvailability\Business\Model\GroupedConditionalAvailabilityReaderInterface;
use FondOfImpala\Zed\ConditionalAvailability\ConditionalAvailabilityDependencyProvider;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailability\Business\ConditionalAvailabilityFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ConditionalAvailability\ConditionalAvailabilityConfig getConfig()
 * @method \FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface getEntityManager()
 */
class ConditionalAvailabilityBusinessFactory extends AbstractBusinessFactory
{
    use LoggerTrait;

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityReaderInterface
     */
    public function createConditionalAvailabilityReader(): ConditionalAvailabilityReaderInterface
    {
        return new ConditionalAvailabilityReader(
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailability\Business\Model\GroupedConditionalAvailabilityReaderInterface
     */
    public function createGroupedConditionalAvailabilityReader(): GroupedConditionalAvailabilityReaderInterface
    {
        return new GroupedConditionalAvailabilityReader(
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityWriterInterface
     */
    public function createConditionalAvailabilityWriter(): ConditionalAvailabilityWriterInterface
    {
        return new ConditionalAvailabilityWriter(
            $this->getEntityManager(),
            $this->createConditionalAvailabilityPluginExecutor(),
            $this->getLogger(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPeriodsPersisterInterface
     */
    public function createConditionalAvailabilityPeriodsPersister(): ConditionalAvailabilityPeriodsPersisterInterface
    {
        return new ConditionalAvailabilityPeriodsPersister($this->getEntityManager());
    }

    /**
     * @return \FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPluginExecutorInterface
     */
    protected function createConditionalAvailabilityPluginExecutor(): ConditionalAvailabilityPluginExecutorInterface
    {
        return new ConditionalAvailabilityPluginExecutor(
            $this->getConditionalAvailabilityPostSavePlugins(),
        );
    }

    /**
     * @return array<\FondOfImpala\Zed\ConditionalAvailabilityExtension\Dependency\Plugin\ConditionalAvailabilityPostSavePluginInterface>
     */
    protected function getConditionalAvailabilityPostSavePlugins(): array
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityDependencyProvider::PLUGINS_CONDITIONAL_AVAILABILITY_POST_SAVE,
        );
    }
}
