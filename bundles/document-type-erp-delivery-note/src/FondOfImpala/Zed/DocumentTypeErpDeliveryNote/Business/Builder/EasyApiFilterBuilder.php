<?php

namespace FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Business\Builder;

use ArrayObject;
use FondOfImpala\Zed\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteConfig;
use FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Persistence\DocumentTypeErpDeliveryNoteRepositoryInterface;
use FondOfOryx\Shared\EasyApi\EasyApiConstants;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\EasyApiFilterConditionTransfer;
use Generated\Shared\Transfer\EasyApiFilterTransfer;
use Generated\Shared\Transfer\ErpDeliveryNoteTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Symfony\Component\HttpFoundation\Response;

class EasyApiFilterBuilder implements EasyApiFilterBuilderInterface
{
    protected DocumentTypeErpDeliveryNoteConfig $config;

    protected DocumentTypeErpDeliveryNoteRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Persistence\DocumentTypeErpDeliveryNoteRepositoryInterface $repository
     * @param \FondOfImpala\Zed\DocumentTypeErpDeliveryNote\DocumentTypeErpDeliveryNoteConfig $config
     */
    public function __construct(
        DocumentTypeErpDeliveryNoteRepositoryInterface $repository,
        DocumentTypeErpDeliveryNoteConfig $config
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

        $erpDeliveryNote = $this->repository->getErpDeliveryNoteWithPermissionCheck($documentRequestTransfer);

        if ($erpDeliveryNote === null) {
            return $transfer->setError($this->createErrorMessage('Delivery note document not found or missing permissions!', Response::HTTP_INTERNAL_SERVER_ERROR));
        }

        return $transfer
            ->setStores([$this->config->getEasyApiStore()])
            ->setConditions($this->createConditions($erpDeliveryNote));
    }

    /**
     * @param \Generated\Shared\Transfer\ErpDeliveryNoteTransfer $erpDeliveryNoteTransfer
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\EasyApiFilterConditionTransfer>
     */
    protected function createConditions(ErpDeliveryNoteTransfer $erpDeliveryNoteTransfer): ArrayObject
    {
        $conditions = new ArrayObject();

        $conditions->append((new EasyApiFilterConditionTransfer())
            ->setField(EasyApiConstants::FIELD_NAME_DOCUMENT_NUMBER)
            ->setValue($erpDeliveryNoteTransfer->getDeliveryNoteNumber()));

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
