<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Ui\Component\Listing\Column;

use Hmh\CatalogPositionRules\Model\RuleConditionsPool;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class RuleRenderer extends Column
{
    private RuleConditionsPool $conditionsPool;
    private Json $jsonSerializer;

    public function __construct(
        Json $jsonSerializer,
        RuleConditionsPool $conditionsPool,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->jsonSerializer = $jsonSerializer;
        $this->conditionsPool = $conditionsPool;
        $data['config']['bodyTmpl'] = $data['config']['bodyTmpl'] ?? 'ui/grid/cells/html';
        $data['config']['escape'] = $data['config']['escape'] ?? false;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        $fieldName = $this->getData('name');

        foreach ($dataSource['data']['items'] as &$item) {
            $item[$fieldName] = $this->formatRuleValue($item[$fieldName] ?? null);
        }

        return $dataSource;
    }

    private function formatRuleValue(mixed $value): string
    {
        if (!is_string($value) || $value === '') {
            return '';
        }

        try {
            $rules = $this->jsonSerializer->unserialize($value);
        } catch (\InvalidArgumentException $exception) {
            return $value;
        }

        if (!is_array($rules)) {
            return $value;
        }

        $rows = [];
        foreach ($rules as $rule) {
            if (!is_array($rule)) {
                continue;
            }

            $conditionTag = $rule['condition'] ?? '';
            $conditionInfo = $this->conditionsPool->getConditionByTag((string) $conditionTag);
            $conditionLabel = $conditionInfo->getLabel() ?? (string) $conditionTag;
            $operator = $rule['operator'] ?? '';
            $ruleValue = $rule['value'] ?? '';
            $score = $rule['score'] ?? '';
            $rows[] = trim(sprintf('Rule: %s, condition: %s target: %s score:%s', $conditionLabel, $operator, $ruleValue, $score));
        }

        return $rows ? implode(' <br> ', $rows) : '';
    }
}
