<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Model;

use Exception;
use FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer;
use Generated\Shared\Transfer\ConditionalAvailabilityTransfer;
use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;

class ConditionalAvailabilityWriter implements ConditionalAvailabilityWriterInterface
{
    use TransactionTrait;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPluginExecutorInterface
     */
    protected $conditionalAvailabilityPluginExecutor;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailability\Persistence\ConditionalAvailabilityEntityManagerInterface $entityManager
     * @param \FondOfImpala\Zed\ConditionalAvailability\Business\Model\ConditionalAvailabilityPluginExecutorInterface $conditionalAvailabilityPluginExecutor
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        ConditionalAvailabilityEntityManagerInterface $entityManager,
        ConditionalAvailabilityPluginExecutorInterface $conditionalAvailabilityPluginExecutor,
        LoggerInterface $logger
    ) {
        $this->entityManager = $entityManager;
        $this->conditionalAvailabilityPluginExecutor = $conditionalAvailabilityPluginExecutor;
        $this->logger = $logger;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function create(ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer): ConditionalAvailabilityResponseTransfer
    {
        $conditionalAvailabilityResponseTransfer = (new ConditionalAvailabilityResponseTransfer())
            ->setConditionalAvailabilityTransfer($conditionalAvailabilityTransfer)
            ->setIsSuccessful(true);

        try {
            $conditionalAvailabilityResponseTransfer = $this->getTransactionHandler()->handleTransaction(
                function () use ($conditionalAvailabilityResponseTransfer) {
                    return $this->executeSaveTransaction($conditionalAvailabilityResponseTransfer);
                },
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data' => $conditionalAvailabilityTransfer->serialize(),
            ]);

            $conditionalAvailabilityResponseTransfer->setConditionalAvailabilityTransfer(null)
                ->setIsSuccessful(false);
        }

        return $conditionalAvailabilityResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function update(ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer): ConditionalAvailabilityResponseTransfer
    {
        $conditionalAvailabilityResponseTransfer = (new ConditionalAvailabilityResponseTransfer())
            ->setConditionalAvailabilityTransfer($conditionalAvailabilityTransfer)
            ->setIsSuccessful(true);

        try {
            $conditionalAvailabilityTransfer->requireIdConditionalAvailability();

            $conditionalAvailabilityResponseTransfer = $this->getTransactionHandler()->handleTransaction(
                function () use ($conditionalAvailabilityResponseTransfer) {
                    return $this->executeSaveTransaction($conditionalAvailabilityResponseTransfer);
                },
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data' => $conditionalAvailabilityTransfer->serialize(),
            ]);

            $conditionalAvailabilityResponseTransfer->setConditionalAvailabilityTransfer(null)
                ->setIsSuccessful(false);
        }

        return $conditionalAvailabilityResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    protected function executeSaveTransaction(
        ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
    ): ConditionalAvailabilityResponseTransfer {
        $conditionalAvailabilityTransfer = $this->entityManager->saveConditionalAvailability(
            $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer(),
        );

        $conditionalAvailabilityResponseTransfer->setConditionalAvailabilityTransfer(
            $conditionalAvailabilityTransfer,
        );

        return $this->conditionalAvailabilityPluginExecutor
            ->executePostSavePlugins($conditionalAvailabilityResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function delete(ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer): ConditionalAvailabilityResponseTransfer
    {
        $conditionalAvailabilityResponseTransfer = (new ConditionalAvailabilityResponseTransfer())
            ->setIsSuccessful(true)
            ->setConditionalAvailabilityTransfer($conditionalAvailabilityTransfer);

        try {
            $conditionalAvailabilityTransfer->requireIdConditionalAvailability();

            $conditionalAvailabilityResponseTransfer = $this->getTransactionHandler()->handleTransaction(
                function () use ($conditionalAvailabilityResponseTransfer) {
                    return $this->executeDeleteTransaction($conditionalAvailabilityResponseTransfer);
                },
            );
        } catch (Exception $exception) {
            $conditionalAvailabilityResponseTransfer->setConditionalAvailabilityTransfer(null)
                ->setIsSuccessful(false);
        }

        return $conditionalAvailabilityResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    protected function executeDeleteTransaction(
        ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
    ): ConditionalAvailabilityResponseTransfer {
        $conditionalAvailabilityTransfer = $conditionalAvailabilityResponseTransfer
            ->getConditionalAvailabilityTransfer();

        $this->entityManager->deleteConditionalAvailabilityById(
            $conditionalAvailabilityTransfer->getIdConditionalAvailability(),
        );

        $conditionalAvailabilityResponseTransfer->setConditionalAvailabilityTransfer(null);

        return $conditionalAvailabilityResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    public function persist(ConditionalAvailabilityTransfer $conditionalAvailabilityTransfer): ConditionalAvailabilityResponseTransfer
    {
        $conditionalAvailabilityResponseTransfer = (new ConditionalAvailabilityResponseTransfer())
            ->setConditionalAvailabilityTransfer($conditionalAvailabilityTransfer)
            ->setIsSuccessful(true);

        try {
            $conditionalAvailabilityResponseTransfer = $this->getTransactionHandler()->handleTransaction(
                function () use ($conditionalAvailabilityResponseTransfer) {
                    return $this->executePersistTransaction($conditionalAvailabilityResponseTransfer);
                },
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data' => $conditionalAvailabilityTransfer->serialize(),
            ]);

            $conditionalAvailabilityResponseTransfer->setConditionalAvailabilityTransfer(null)
                ->setIsSuccessful(false);
        }

        return $conditionalAvailabilityResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityResponseTransfer
     */
    protected function executePersistTransaction(
        ConditionalAvailabilityResponseTransfer $conditionalAvailabilityResponseTransfer
    ): ConditionalAvailabilityResponseTransfer {
        $conditionalAvailabilityTransfer = $this->entityManager->persistConditionalAvailability(
            $conditionalAvailabilityResponseTransfer->getConditionalAvailabilityTransfer(),
        );

        $conditionalAvailabilityResponseTransfer->setConditionalAvailabilityTransfer(
            $conditionalAvailabilityTransfer,
        );

        return $this->conditionalAvailabilityPluginExecutor
            ->executePostSavePlugins($conditionalAvailabilityResponseTransfer);
    }
}
