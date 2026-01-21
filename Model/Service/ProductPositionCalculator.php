<?php
declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Model\Service;

use Hmh\CatalogPositionRules\Api\ProductPositionRuleCategoryRepositoryInterface;
use Hmh\CatalogPositionRules\Api\ProductPositionRuleRepositoryInterface;
use Hmh\CatalogPositionRules\Model\Data\ConditionInfoDto;
use Hmh\CatalogPositionRules\Model\RuleConditionsPool;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class ProductPositionCalculator
{
    public function __construct(
        private readonly RuleConditionsPool $conditionsPool,
        private readonly ProductPositionRuleCategoryRepositoryInterface $positionRuleCategoryRepository,
        private readonly ProductPositionRuleRepositoryInterface $positionRuleRepository,
        private readonly CollectionFactory $productCollectionFactory,
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly Json $jsonSerializer
    ) {
    }

    public function process(int $categoryId): void
    {
        $ruleId = $this->positionRuleCategoryRepository->getByCategoryId($categoryId)?->getRuleId();
        if (!$ruleId) {
            return;
        }
        $ruleConditions = $this->extractRuleConditions((int)$ruleId);
        $this->calculateProductsPosition($categoryId, $ruleConditions);
    }

    private function calculateProductsPosition(int $categoryId, array $ruleConditions): void
    {
        try {
            $category = $this->categoryRepository->get($categoryId);
        } catch (\Exception $exception) {
            return;
        }
        $productsPosition = $category->getProductsPosition();
        $rankingScore = [];
        foreach ($productsPosition as $productId => $position) {
            $rankingScore[$productId] = $this->conditionsPool->calculateRankingScore($productId, $ruleConditions);
        }

        $newProductPosition = $this->rankProductByScore($rankingScore);

        $category->setPostedProducts($newProductPosition);
        try {
            $this->categoryRepository->save($category);
        } catch (\Exception $exception) {
        }
    }

    private function rankProductByScore(array $rankingScore): array
    {
        arsort($rankingScore, SORT_NUMERIC);
        $ranked = [];
        $rank = 1;
        foreach ($rankingScore as $key => $value) {
            $ranked[$key] = $rank++;
        }

        return $ranked;
    }

    private function extractRuleConditions(int $ruleId): array
    {
        $rule = $this->positionRuleRepository->getById((int)$ruleId);
        $rulesData = $rule->getRule();
        if (is_string($rulesData)) {
            try {
                $rulesData = $this->jsonSerializer->unserialize($rulesData);
            } catch (\InvalidArgumentException $exception) {
                $rulesData = [];
            }
        }
        $conditions = [];
        foreach ($rulesData as $key => $rule) {
            $conditionInfoDto = new ConditionInfoDto();
            $conditionInfoDto->setTag($rule['condition']);
            $conditionInfoDto->setOperator($rule['operator']);
            $conditionInfoDto->setTargetValue($rule['value']);
            $conditionInfoDto->setScore($rule['score']);
            $conditions[] = $conditionInfoDto;
        }

        return $conditions;
    }
}
