<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Block\Adminhtml\Category;

use Hmh\CatalogPositionRules\Api\ProductPositionRuleCategoryRepositoryInterface;
use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleSearchResultsInterface;
use Hmh\CatalogPositionRules\Model\Config\ConfigProvider;
use Hmh\CatalogPositionRules\Model\RuleConditionsPool;
use Hmh\CatalogPositionRules\Model\ProductPositionRuleRepository;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Api\SearchCriteriaBuilder;

class ProductPositionRules extends Template
{
    public function __construct(
        Context $context,
        private readonly RuleConditionsPool $conditionsPool,
        private readonly ProductPositionRuleRepository $positionRuleRepository,
        private readonly ProductPositionRuleCategoryRepositoryInterface $ruleCategoryRepository,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly ConfigProvider $configProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getPositionRules(): ProductPositionRuleSearchResultsInterface
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();

        return $this->positionRuleRepository->getList($searchCriteria);
    }

    public function getCurrentRuleId(): ?int
    {
        $categoryId = (int) $this->getRequest()->getParam('id', 0);
        if ($categoryId <= 0) {
            return null;
        }

        $ruleCategory = $this->ruleCategoryRepository->getByCategoryId($categoryId);
        if (!$ruleCategory) {
            return null;
        }

        return $ruleCategory->getRuleId();
    }

    public function isEnabled(): bool
    {
        return $this->configProvider->isEnabled();
    }

}
