<?php

namespace FondOfImpala\Glue\CartValidation\Processor\Translator;

interface ValidationMessageTranslatorInterface
{
    /**
     * @param array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface> $resources
     *
     * @return array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface>
     */
    public function translate(array $resources): array;
}
