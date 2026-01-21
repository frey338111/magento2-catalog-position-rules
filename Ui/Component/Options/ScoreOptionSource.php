<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Ui\Component\Options;

use Magento\Framework\Option\ArrayInterface;

class ScoreOptionSource implements ArrayInterface
{
    public function toOptionArray(): array
    {
        return array_map(
            static fn (int $score): array => [
                'value' => $score,
                'label' => (string)$score,
            ],
            range(1, 10)
        );
    }
}
