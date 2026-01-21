<?php
declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Model;

use Hmh\CatalogPositionRules\Api\RuleConditionInterface;
use Hmh\CatalogPositionRules\Model\Data\ConditionInfoDto;
use Magento\Catalog\Api\ProductRepositoryInterface;

class RuleConditionsPool
{
    public function __construct(
        private readonly array $conditions,
        private readonly ProductRepositoryInterface $productRepository
    ) {
    }

    /**
     * Return all rule descriptors (no execution)
     *
     * @return ConditionInfoDto[]
     */
    public function getAllConditionsInfo(): array
    {
        $labels = [];
        foreach ($this->conditions as $condition) {
            $conditionInfoDto = new ConditionInfoDto();
            $conditionInfoDto->setLabel($condition->getLabel())
                ->setTag($condition->getTag());
            $labels[] = $conditionInfoDto;
        }

        return $labels;
    }

    public function getConditionByTag(string $tag): ?ConditionInfoDto
    {
        if (!isset($this->conditions[$tag])) {
            return null;
        }
        $conditionInfoDto = new ConditionInfoDto();
        $conditionInfoDto->setLabel($this->conditions[$tag]?->getLabel())
            ->setTag($this->conditions[$tag]?->getTag());

        return $conditionInfoDto;
    }

    public function calculateRankingScore(int $productId, array $rankingRules): int
    {
        $score = 0;
        $product = $this->productRepository->getById($productId);
        foreach ($rankingRules as $rule) {
            if (!isset($this->conditions[$rule->getTag()]) || !($this->conditions[$rule->getTag()] instanceof RuleConditionInterface)) {
                continue;
            }
            $score += $this->conditions[$rule->getTag()]->isConditionMatch($product, $rule) === true ? $rule->getScore() : 0;
        }

        return $score;
    }
}
