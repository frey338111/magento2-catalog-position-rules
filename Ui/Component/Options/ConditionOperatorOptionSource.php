<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Ui\Component\Options;

use Magento\Framework\Option\ArrayInterface;

class ConditionOperatorOptionSource implements ArrayInterface
{
    public function toOptionArray(): array
    {
        return [
            [
                'value' => 'gt',
                'label' => __('Greater than'),
            ],
            [
                'value' => 'lt',
                'label' => __('Less than'),
            ],
            [
                'value' => 'eq',
                'label' => __('Equal to'),
            ],
            [
                'value' => 'ct',
                'label' => __('Contain'),
            ],
        ];
    }
}
