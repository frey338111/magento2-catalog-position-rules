<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Model;

use Hmh\CatalogPositionRules\Api\ProductPositionRuleRepositoryInterface;
use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleInterface;
use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleSearchResultsInterface;
use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleSearchResultsInterfaceFactory;
use Hmh\CatalogPositionRules\Model\ResourceModel\ProductPositionRule as ProductPositionRuleResource;
use Hmh\CatalogPositionRules\Model\ResourceModel\ProductPositionRule\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class ProductPositionRuleRepository implements ProductPositionRuleRepositoryInterface
{
    /**
     * @param ProductPositionRuleResource $resource
     * @param ProductPositionRuleFactory $ruleFactory
     * @param CollectionFactory $collectionFactory
     * @param ProductPositionRuleSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        private readonly ProductPositionRuleResource $resource,
        private readonly ProductPositionRuleFactory $ruleFactory,
        private readonly CollectionFactory $collectionFactory,
        private readonly ProductPositionRuleSearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor
    ) {
    }

    /**
     * @inheritDoc
     */
    public function save(ProductPositionRuleInterface $rule): ProductPositionRuleInterface
    {
        try {
            $this->resource->save($rule);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save product position rule: %1', $exception->getMessage()),
                $exception
            );
        }

        return $rule;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ProductPositionRuleInterface
    {
        $rule = $this->ruleFactory->create();
        $this->resource->load($rule, $id);

        if (!$rule->getId()) {
            throw new NoSuchEntityException(__('Product position rule with ID "%1" does not exist.', $id));
        }

        return $rule;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ProductPositionRuleSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(ProductPositionRuleInterface $rule): bool
    {
        try {
            $this->resource->delete($rule);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete product position rule: %1', $exception->getMessage()),
                $exception
            );
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }
}
