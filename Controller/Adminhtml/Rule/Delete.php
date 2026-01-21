<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Controller\Adminhtml\Rule;

use Hmh\CatalogPositionRules\Api\ProductPositionRuleRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Delete extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Hmh_CatalogPositionRules::rules';

    private ProductPositionRuleRepositoryInterface $repository;

    public function __construct(
        Context $context,
        ProductPositionRuleRepositoryInterface $repository
    ) {
        parent::__construct($context);
        $this->repository = $repository;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int)$this->getRequest()->getParam('id');

        if (!$id) {
            $this->messageManager->addErrorMessage(__('Unable to find a rule to delete.'));
            return $resultRedirect->setPath('hmh_catalogpositionrules/rule/index');
        }

        try {
            $this->repository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('The rule has been deleted.'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Could not delete the rule: %1', $exception->getMessage()));
        }

        return $resultRedirect->setPath('hmh_catalogpositionrules/rule/index');
    }
}
