<?php

namespace FondOfImpala\Zed\DocumentTypeErpOrder\Business\Builder;

use ArrayObject;
use FondOfImpala\Zed\DocumentTypeErpOrder\DocumentTypeErpOrderConfig;
use FondOfImpala\Zed\DocumentTypeErpOrder\Persistence\DocumentTypeErpOrderRepositoryInterface;
use FondOfOryx\Shared\EasyApi\EasyApiConstants;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterConditionTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Generated\Shared\Transfer\ErpOrderTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Symfony\Component\HttpFoundation\Response;

class EasyApiFilterBuilder implements EasyApiFilterBuilderInterface
{
    protected DocumentTypeErpOrderConfig $config;

    protected DocumentTypeErpOrderRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\DocumentTypeErpOrder\Persistence\DocumentTypeErpOrderRepositoryInterface $repository
     * @param \FondOfImpala\Zed\DocumentTypeErpOrder\DocumentTypeErpOrderConfig $config
     */
    public function __construct(
        DocumentTypeErpOrderRepositoryInterface $repository,
        DocumentTypeErpOrderConfig $config
    ) {
        $this->repository = $repository;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EasyApiFilterTransfer
     */
    public function build(DocumentRequestTransfer $documentRequestTransfer): EasyApiFilterTransfer
    {
        $transfer = new EasyApiFilterTransfer();

        $erpOrder = $this->repository->getErpOrderWithPermissionCheck($documentRequestTransfer);

        if ($erpOrder === null) {
            return $transfer->setError($this->createErrorMessage('Order document not found or missing permissions!', Response::HTTP_INTERNAL_SERVER_ERROR));
        }

        return $transfer
            ->setStores([$this->config->getEasyApiStore()])
            ->setConditions($this->createConditions($erpOrder));
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderTransfer $erpOrderTransfer
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\EasyApiFilterConditionTransfer>
     */
    protected function createConditions(ErpOrderTransfer $erpOrderTransfer): ArrayObject
    {
        $conditions = new ArrayObject();

        $conditions->append((new EasyApiFilterConditionTransfer())
            ->setField(EasyApiConstants::FIELD_NAME_DOCUMENT_NUMBER)
            ->setValue($erpOrderTransfer->getExternalReference()));

        return $conditions;
    }

    /**
     * @param string $message
     * @param int $code
     *
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    protected function createErrorMessage(string $message, int $code): MessageTransfer
    {
        return (new MessageTransfer())
            ->setMessage($message)
            ->setType('error')
            ->setValue((string)$code);
    }
}
