<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Controller\Adminhtml\Category;

use Hmh\CatalogPositionRules\Api\ProductPositionRuleCategoryRepositoryInterface;
use Hmh\CatalogPositionRules\Model\ProductPositionRuleCategoryFactory;
use Hmh\CatalogPositionRules\Model\Service\ProductPositionCalculator;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Data\Form\FormKey\Validator;

class CalculateRanking extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Magento_Backend::admin';

    public function __construct(
        Context $context,
        private readonly JsonFactory $resultJsonFactory,
        private readonly Validator $formKeyValidator,
        private readonly ProductPositionRuleCategoryRepositoryInterface $ruleCategoryRepository,
        private readonly ProductPositionRuleCategoryFactory $ruleCategoryFactory,
        private readonly ProductPositionCalculator $positionCalculator
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            $result = $this->resultJsonFactory->create();

            return $result->setData([
                'success' => false,
                'message' => __('Invalid form key. Please refresh the page.'),
            ]);
        }

        $ruleId = (int) $this->getRequest()->getParam('rule_id', 0);
        $categoryId = (int) $this->getRequest()->getParam('category_id', 0);

        $result = $this->resultJsonFactory->create();
        try {
            $this->saveRuleOnCategory($ruleId, $categoryId);
            $this->positionCalculator->process($categoryId);
        } catch (\Exception $exception) {
            return $result->setData([
                'success' => false,
                'execute' => __('Ranking calculation failed.'),
            ]);
        }

        return $result->setData([
            'success' => true,
            'message' => __('Ranking calculation Completed.'),
        ]);
    }

    private function saveRuleOnCategory(int $ruleId, int $categoryId): void
    {
        if ($ruleId <= 0 || $categoryId <= 0) {
            return;
        }

        try {
            $ruleCategory = $this->ruleCategoryRepository->getByCategoryId($categoryId);
            if (!$ruleCategory) {
                $ruleCategory = $this->ruleCategoryFactory->create();
                $ruleCategory->setCategoryId($categoryId);
            }

            if ((int) $ruleCategory->getRuleId() === $ruleId) {
                return;
            }

            $ruleCategory->setRuleId($ruleId);
            $this->ruleCategoryRepository->save($ruleCategory);
        } catch (\Exception $exception) {
        }
    }
}
