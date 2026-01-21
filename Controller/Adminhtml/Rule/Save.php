<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Controller\Adminhtml\Rule;

use Hmh\CatalogPositionRules\Model\ProductPositionRuleFactory;
use Hmh\CatalogPositionRules\Api\ProductPositionRuleRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json;

class Save extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Hmh_CatalogPositionRules::rules';

    private ProductPositionRuleRepositoryInterface $repository;
    private ProductPositionRuleFactory $ruleFactory;
    private DataPersistorInterface $dataPersistor;
    private Json $jsonSerializer;

    public function __construct(
        Context $context,
        ProductPositionRuleRepositoryInterface $repository,
        ProductPositionRuleFactory $ruleFactory,
        DataPersistorInterface $dataPersistor,
        Json $jsonSerializer
    ) {
        parent::__construct($context);
        $this->repository = $repository;
        $this->ruleFactory = $ruleFactory;
        $this->dataPersistor = $dataPersistor;
        $this->jsonSerializer = $jsonSerializer;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (is_string($data)) {
            try {
                $data = $this->jsonSerializer->unserialize($data);
            } catch (\InvalidArgumentException $exception) {
                // Leave data as-is when the payload is not JSON.
            }
        }

        if (!$data) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        $data = $data['data'] ?? $data;
        $id = isset($data['id']) ? (int)$data['id'] : 0;

        try {
            if ($id) {
                $rule = $this->repository->getById($id);
            } else {
                $rule = $this->ruleFactory->create();
            }

            $rule->setTitle($data['title']);
            $rule->setRule($this->jsonSerializer->serialize($data['product_ranking_rules']));
            $this->repository->save($rule);
            $this->messageManager->addSuccessMessage(__('The rule has been saved.'));
            $this->dataPersistor->clear('hmh_catalog_position_rules_form');

            return $this->resultRedirectFactory->create()->setPath('*/*/');
        } catch (LocalizedException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving the rule.'));
        }

        $this->dataPersistor->set('hmh_catalog_position_rules_form', $data);

        return $this->resultRedirectFactory->create()->setPath('*/*/edit', ['id' => $id]);
    }
}
