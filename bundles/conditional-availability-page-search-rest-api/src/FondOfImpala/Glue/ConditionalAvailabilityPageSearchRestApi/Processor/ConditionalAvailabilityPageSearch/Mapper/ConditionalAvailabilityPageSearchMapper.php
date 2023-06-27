<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Mapper;

use Generated\Shared\Transfer\RestConditionalAvailabilityPageSearchCollectionResponseTransfer;
use Generated\Shared\Transfer\RestConditionalAvailabilityPeriodTransfer;

class ConditionalAvailabilityPageSearchMapper implements ConditionalAvailabilityPageSearchMapperInterface
{
    /**
     * @var string
     */
    protected const SEARCH_RESULT_KEY_PERIODS = 'periods';

    /**
     * @var array<\FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApiExtension\Dependency\Plugin\RestConditionalAvailabilityPeriodMapperPluginInterface>
     */
    protected array $restConditionalAvailabilityPeriodMapperPlugins;

    /**
     * @param array<\FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApiExtension\Dependency\Plugin\RestConditionalAvailabilityPeriodMapperPluginInterface> $restConditionalAvailabilityPeriodMapperPlugins
     */
    public function __construct(
        array $restConditionalAvailabilityPeriodMapperPlugins
    ) {
        $this->restConditionalAvailabilityPeriodMapperPlugins = $restConditionalAvailabilityPeriodMapperPlugins;
    }

    /**
     * @param array $searchResult
     *
     * @return \Generated\Shared\Transfer\RestConditionalAvailabilityPageSearchCollectionResponseTransfer
     */
    public function mapSearchResultToRestConditionalAvailabilityPageSearchCollectionResponseTransfer(
        array $searchResult
    ): RestConditionalAvailabilityPageSearchCollectionResponseTransfer {
        $restConditionalAvailabilityPeriodCollectionResponseTransfer = (new RestConditionalAvailabilityPageSearchCollectionResponseTransfer())
            ->fromArray($searchResult, true);

        $restConditionalAvailabilityPeriodCollectionResponseTransfer = $this->mapSearchResultToRestConditionalAvailabilityPeriodTransfers(
            $searchResult,
            $restConditionalAvailabilityPeriodCollectionResponseTransfer,
        );

        return $restConditionalAvailabilityPeriodCollectionResponseTransfer;
    }

    /**
     * @param array $restSearchResponse
     * @param \Generated\Shared\Transfer\RestConditionalAvailabilityPageSearchCollectionResponseTransfer $restConditionalAvailabilityPeriodCollectionResponseTransfer
     *
     * @return \Generated\Shared\Transfer\RestConditionalAvailabilityPageSearchCollectionResponseTransfer
     */
    protected function mapSearchResultToRestConditionalAvailabilityPeriodTransfers(
        array $restSearchResponse,
        RestConditionalAvailabilityPageSearchCollectionResponseTransfer $restConditionalAvailabilityPeriodCollectionResponseTransfer
    ): RestConditionalAvailabilityPageSearchCollectionResponseTransfer {
        if (
            !isset($restSearchResponse[static::SEARCH_RESULT_KEY_PERIODS])
            || !is_array($restSearchResponse[static::SEARCH_RESULT_KEY_PERIODS])
        ) {
            return $restConditionalAvailabilityPeriodCollectionResponseTransfer;
        }

        foreach ($restSearchResponse[static::SEARCH_RESULT_KEY_PERIODS] as $period) {
            $restConditionalAvailabilityPeriodTransfer = (new RestConditionalAvailabilityPeriodTransfer())
                ->fromArray($period, true);

            foreach ($this->restConditionalAvailabilityPeriodMapperPlugins as $restConditionalAvailabilityPeriodMapperPlugin) {
                $restConditionalAvailabilityPeriodTransfer = $restConditionalAvailabilityPeriodMapperPlugin
                    ->mapPeriodDataToRestConditionalAvailabilityPeriodTransfer(
                        $period,
                        $restConditionalAvailabilityPeriodTransfer,
                    );
            }

            $restConditionalAvailabilityPeriodCollectionResponseTransfer->addConditionalAvailabilityPeriods(
                $restConditionalAvailabilityPeriodTransfer,
            );
        }

        return $restConditionalAvailabilityPeriodCollectionResponseTransfer;
    }
}
