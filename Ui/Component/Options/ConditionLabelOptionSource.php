<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Ui\Component\Options;

use Hmh\CatalogPositionRules\Model\RuleConditionsPool;
use Magento\Framework\Option\ArrayInterface;

class ConditionLabelOptionSource implements ArrayInterface
{
    public function __construct(
        private readonly RuleConditionsPool $conditionsPool
    ) {}

    public function toOptionArray(): array
    {
        $options = [];

        foreach ($this->conditionsPool->getAllConditionsInfo() as $condition) {
            $options[] = [
                'value' => $condition->getTag(),
                'label' => $condition->getLabel(),
            ];
        }

        return $options;
    }
}
