<?php

namespace FondOfImpala\Zed\ErpOrderCancellation;

use ArrayObject;
use FondOfImpala\Zed\ErpOrderCancellation\Exception\WrongInterfaceException;
use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationItemPostSavePluginInterface;
use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationItemPreSavePluginInterface;
use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostSavePluginInterface;
use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostTransactionPluginInterface;
use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPreSavePluginInterface;
use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\Persistence\ErpOrderCancellationTransferExpanderPluginInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ErpOrderCancellationDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PLUGIN_ERP_ORDER_CANCELLATION_PRE_SAVE = 'PLUGIN_ERP_ORDER_CANCELLATION_PRE_SAVE';

    /**
     * @var string
     */
    public const PLUGIN_ERP_ORDER_CANCELLATION_POST_SAVE = 'PLUGIN_ERP_ORDER_CANCELLATION_POST_SAVE';

    /**
     * @var string
     */
    public const PLUGIN_ERP_ORDER_CANCELLATION_POST_TRANSACTION = 'PLUGIN_ERP_ORDER_CANCELLATION_POST_TRANSACTION';

    /**
     * @var string
     */
    public const PLUGIN_ERP_ORDER_CANCELLATION_ITEM_POST_SAVE = 'PLUGIN_ERP_ORDER_CANCELLATION_ITEM_POST_SAVE';

    /**
     * @var string
     */
    public const PLUGIN_ERP_ORDER_CANCELLATION_ITEM_PRE_SAVE = 'PLUGIN_ERP_ORDER_CANCELLATION_ITEM_PRE_SAVE';

    /**
     * @var string
     */
    public const PLUGIN_ERP_ORDER_CANCELLATION_ENTITY_TO_TRANSFER_EXPANDER = 'PLUGIN_ERP_ORDER_CANCELLATION_ENTITY_TO_TRANSFER_EXPANDER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        $container = $this->addErpOrderCancellationPreSavePlugin($container);
        $container = $this->addErpOrderCancellationPostSavePlugin($container);
        $container = $this->addErpOrderCancellationPostTransactionPlugin($container);
        $container = $this->addErpOrderCancellationItemPreSavePlugin($container);

        return $this->addErpOrderCancellationItemPostSavePlugin($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container =  parent::providePersistenceLayerDependencies($container);

        return $this->addErpOrderCancellationEntityToTransferExpanderPlugin($container);
    }


    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addErpOrderCancellationPostSavePlugin(Container $container): Container
    {
        $container[static::PLUGIN_ERP_ORDER_CANCELLATION_POST_SAVE] = function () {
            $plugins = $this->getErpOrderCancellationPostSavePlugin();
            $this->validatePlugin($plugins, ErpOrderCancellationPostSavePluginInterface::class);

            return new ArrayObject($plugins);
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addErpOrderCancellationPostTransactionPlugin(Container $container): Container
    {
        $container[static::PLUGIN_ERP_ORDER_CANCELLATION_POST_TRANSACTION] = function () {
            $plugins = $this->getErpOrderCancellationPostTransactionPlugin();
            $this->validatePlugin($plugins, ErpOrderCancellationPostTransactionPluginInterface::class);

            return new ArrayObject($plugins);
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addErpOrderCancellationPreSavePlugin(Container $container): Container
    {
        $container[static::PLUGIN_ERP_ORDER_CANCELLATION_PRE_SAVE] = function () {
            $plugins = $this->getErpOrderCancellationPreSavePlugin();
            $this->validatePlugin($plugins, ErpOrderCancellationPreSavePluginInterface::class);

            return new ArrayObject($plugins);
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addErpOrderCancellationItemPostSavePlugin(Container $container): Container
    {
        $container[static::PLUGIN_ERP_ORDER_CANCELLATION_ITEM_POST_SAVE] = function () {
            $plugins = $this->getErpOrderCancellationItemPostSavePlugin();
            $this->validatePlugin($plugins, ErpOrderCancellationItemPostSavePluginInterface::class);

            return new ArrayObject($plugins);
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addErpOrderCancellationItemPreSavePlugin(Container $container): Container
    {
        $container[static::PLUGIN_ERP_ORDER_CANCELLATION_ITEM_PRE_SAVE] = function () {
            $plugins = $this->getErpOrderCancellationItemPreSavePlugin();
            $this->validatePlugin($plugins, ErpOrderCancellationItemPreSavePluginInterface::class);

            return new ArrayObject($plugins);
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addErpOrderCancellationEntityToTransferExpanderPlugin(Container $container): Container
    {
        $container[static::PLUGIN_ERP_ORDER_CANCELLATION_ENTITY_TO_TRANSFER_EXPANDER] = function () {
            $plugins = $this->getErpOrderCancellationEntityToTransferExpanderPlugin();
            $this->validatePlugin($plugins, ErpOrderCancellationTransferExpanderPluginInterface::class);

            return new ArrayObject($plugins);
        };

        return $container;
    }

    /**
     * @param array $plugins
     * @param string $class
     *
     * @throws \FondOfImpala\Zed\ErpOrderCancellation\Exception\WrongInterfaceException
     *
     * @return void
     */
    protected function validatePlugin(array $plugins, string $class): void
    {
        foreach ($plugins as $plugin) {
            if (($plugin instanceof $class) === false) {
                throw new WrongInterfaceException(sprintf(
                    'Plugin %s has to implement interface from type %s',
                    get_class($plugin),
                    $class,
                ));
            }
        }
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostSavePluginInterface>
     */
    protected function getErpOrderCancellationPostSavePlugin(): array
    {
        return [];
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostTransactionPluginInterface>
     */
    protected function getErpOrderCancellationPostTransactionPlugin(): array
    {
        return [];
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPreSavePluginInterface>
     */
    protected function getErpOrderCancellationPreSavePlugin(): array
    {
        return [];
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationItemPostSavePluginInterface>
     */
    protected function getErpOrderCancellationItemPostSavePlugin(): array
    {
        return [];
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationItemPreSavePluginInterface>
     */
    protected function getErpOrderCancellationItemPreSavePlugin(): array
    {
        return [];
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\Persistence\ErpOrderCancellationTransferExpanderPluginInterface>
     */
    protected function getErpOrderCancellationEntityToTransferExpanderPlugin(): array
    {
        return [];
    }
}
