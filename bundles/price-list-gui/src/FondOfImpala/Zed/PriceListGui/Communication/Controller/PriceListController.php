<?php

namespace FondOfImpala\Zed\PriceListGui\Communication\Controller;

use Exception;
use FondOfImpala\Zed\PriceListGui\Communication\Form\PriceListForm;
use Generated\Shared\Transfer\PriceListTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

/**
 * @method \FondOfImpala\Zed\PriceListGui\Communication\PriceListGuiCommunicationFactory getFactory()
 */
class PriceListController extends AbstractController
{
    /**
     * @var string
     */
    public const URL_PARAMETER_ID_PRICE_LIST = 'id-price-list';

    /**
     * @var string
     */
    public const URL_LIST_PRICE_LIST = '/price-list-gui/price-list/index';

    /**
     * @var string
     */
    public const URL_UPDATE_PRICE_LIST = '/price-list-gui/price-list/update?id-price-list=%d';

    /**
     * @var string
     */
    protected const MESSAGE_PRICE_LIST_NOT_FOUND = "Price list couldn't be found";

    /**
     * @return array
     */
    public function indexAction()
    {
        $priceListTable = $this->getFactory()->createPriceListTable();

        return $this->viewResponse([
            'priceListTable' => $priceListTable->render(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tableAction()
    {
        $priceListTable = $this->getFactory()->createPriceListTable();

        return $this->jsonResponse(
            $priceListTable->fetchData(),
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function createAction(Request $request)
    {
        $priceListForm = $this->getFactory()
            ->createPriceListForm()
            ->handleRequest($request);

        if ($priceListForm->isSubmitted() && $priceListForm->isValid()) {
            $formData = $priceListForm->getData();

            try {
                $priceListTransfer = (new PriceListTransfer())->fromArray($formData, true);

                $priceListTransfer = $this->getFactory()->getPriceListFacade()
                    ->createPriceList($priceListTransfer);

                $this->addSuccessMessage(
                    sprintf('Price list "%s" successfully added.', $formData[PriceListForm::FIELD_NAME]),
                );

                return $this->redirectResponse(
                    sprintf(static::URL_UPDATE_PRICE_LIST, $priceListTransfer->getIdPriceList()),
                );
            } catch (Exception $e) {
                $this->addErrorMessage($e->getMessage());
            }
        }

        return $this->viewResponse([
            'priceListForm' => $priceListForm->createView(),
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function updateAction(Request $request)
    {
        $idPriceList = $this->castId($request->query->get(static::URL_PARAMETER_ID_PRICE_LIST));

        if (!$idPriceList) {
            $this->addErrorMessage('Missing price list id!');

            return $this->redirectResponse(static::URL_LIST_PRICE_LIST);
        }

        $dataProvider = $this->getFactory()->createPriceListFormDataProvider();
        $formData = $dataProvider->getData($idPriceList);

        if (!$formData) {
            $this->addErrorMessage(static::MESSAGE_PRICE_LIST_NOT_FOUND);

            return $this->redirectResponse(static::URL_LIST_PRICE_LIST);
        }

        $priceListForm = $this->getFactory()
            ->createPriceListForm($formData)
            ->handleRequest($request);

        $priceListTransfer = (new PriceListTransfer())->fromArray($priceListForm->getData(), true);

        if ($priceListForm->isSubmitted() && $priceListForm->isValid()) {
            try {
                $priceListTransfer = $this->getFactory()->getPriceListFacade()
                    ->updatePriceList($priceListTransfer);

                $this->addSuccessMessage(
                    sprintf('Price list "%s" successfully updated.', $formData[PriceListForm::FIELD_NAME]),
                );

                return $this->redirectResponse(
                    sprintf(static::URL_UPDATE_PRICE_LIST, $priceListTransfer->getIdPriceList()),
                );
            } catch (Exception $e) {
                $this->addErrorMessage($e->getMessage());
            }
        }

        return [
            'priceListForm' => $priceListForm->createView(),
            'priceListTransfer' => $priceListTransfer,
        ];
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        if (!$request->isMethod(Request::METHOD_DELETE)) {
            throw new MethodNotAllowedHttpException(
                [Request::METHOD_DELETE],
                'This action requires a DELETE request.',
            );
        }

        $idPriceList = $this->castId($request->get(static::URL_PARAMETER_ID_PRICE_LIST));

        if (!$idPriceList) {
            $this->addErrorMessage('Missing price list id!');

            return $this->redirectResponse(static::URL_LIST_PRICE_LIST);
        }

        $priceListTransfer = (new PriceListTransfer())->setIdPriceList($idPriceList);

        try {
            $this->getFactory()->getPriceListFacade()->deletePriceListById($priceListTransfer);

            $this->addSuccessMessage('Price list was successfully removed.');
        } catch (Exception $e) {
            $this->addErrorMessage($e->getMessage());
        }

        return $this->redirectResponse(static::URL_LIST_PRICE_LIST);
    }
}
