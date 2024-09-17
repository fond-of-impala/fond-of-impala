<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business;

use FondOfImpala\Zed\ErpOrderCancellation\Business\Handler\ErpOrderCancellationItemHandler;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Handler\ErpOrderCancellationItemHandlerInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ErpOrderCancellationItemReader;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ErpOrderCancellationItemReaderInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ErpOrderCancellationReader;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ReaderInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationItemWriter;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationItemWriterInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationWriter;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationWriterInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationItemPluginExecutor;
use FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationItemPluginExecutorInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationPluginExecutor;
use FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationPluginExecutorInterface;
use FondOfImpala\Zed\ErpOrderCancellation\ErpOrderCancellationDependencyProvider;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationRepositoryInterface getRepository()()
 */
class ErpOrderCancellationBusinessFactory extends AbstractBusinessFactory
{
    use LoggerTrait;

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationWriterInterface
     */
    public function createErpOrderCancellationWriter(): ErpOrderCancellationWriterInterface
    {
        return new ErpOrderCancellationWriter(
            $this->getEntityManager(),
            $this->createErpOrderCancellationPluginExecutor(),
            $this->getLogger(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationItemWriterInterface
     */
    public function createErpOrderCancellationItemWriter(): ErpOrderCancellationItemWriterInterface
    {
        return new ErpOrderCancellationItemWriter(
            $this->getEntityManager(),
            $this->createErpOrderCancellationItemPluginExecutor(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellation\Business\Handler\ErpOrderCancellationItemHandlerInterface
     */
    public function createErpOrderCancellationItemHandler(): ErpOrderCancellationItemHandlerInterface
    {
        return new ErpOrderCancellationItemHandler(
            $this->createErpOrderCancellationItemWriter(),
            $this->createErpOrderCancellationItemReader(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ReaderInterface
     */
    public function createErpOrderCancellationReader(): ReaderInterface
    {
        return new ErpOrderCancellationReader($this->getRepository());
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ErpOrderCancellationItemReaderInterface
     */
    public function createErpOrderCancellationItemReader(): ErpOrderCancellationItemReaderInterface
    {
        return new ErpOrderCancellationItemReader($this->getRepository());
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationPluginExecutorInterface
     */
    protected function createErpOrderCancellationPluginExecutor(): ErpOrderCancellationPluginExecutorInterface
    {
        return new ErpOrderCancellationPluginExecutor(
            $this->getErpOrderCancellationPreSavePlugin(),
            $this->getErpOrderCancellationPostSavePlugin(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationItemPluginExecutorInterface
     */
    protected function createErpOrderCancellationItemPluginExecutor(): ErpOrderCancellationItemPluginExecutorInterface
    {
        return new ErpOrderCancellationItemPluginExecutor(
            $this->getErpOrderCancellationItemPreSavePlugin(),
            $this->getErpOrderCancellationItemPostSavePlugin(),
        );
    }
    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPreSavePluginInterface>
     */
    public function getErpOrderCancellationPreSavePlugin(): array
    {
        return $this->getProvidedDependency(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_PRE_SAVE)->getArrayCopy();
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostSavePluginInterface>
     */
    public function getErpOrderCancellationPostSavePlugin(): array
    {
        return $this->getProvidedDependency(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_POST_SAVE)->getArrayCopy();
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationItemPreSavePluginInterface>
     */
    public function getErpOrderCancellationItemPreSavePlugin(): array
    {
        return $this->getProvidedDependency(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_ITEM_PRE_SAVE)->getArrayCopy();
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationItemPostSavePluginInterface>
     */
    public function getErpOrderCancellationItemPostSavePlugin(): array
    {
        return $this->getProvidedDependency(ErpOrderCancellationDependencyProvider::PLUGIN_ERP_ORDER_CANCELLATION_ITEM_POST_SAVE)->getArrayCopy();
    }
}
