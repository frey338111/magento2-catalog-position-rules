<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Model;

use Hmh\CatalogPositionRules\Api\ProductPositionRuleCategoryRepositoryInterface;
use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleCategoryInterface;
use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleCategorySearchResultsInterface;
use Hmh\CatalogPositionRules\Api\Data\ProductPositionRuleCategorySearchResultsInterfaceFactory;
use Hmh\CatalogPositionRules\Model\ResourceModel\ProductPositionRuleCategory as ProductPositionRuleCategoryResource;
use Hmh\CatalogPositionRules\Model\ResourceModel\ProductPositionRuleCategory\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class ProductPositionRuleCategoryRepository implements ProductPositionRuleCategoryRepositoryInterface
{
    public function __construct(
        private readonly ProductPositionRuleCategoryResource $resource,
        private readonly ProductPositionRuleCategoryFactory $ruleCategoryFactory,
        private readonly CollectionFactory $collectionFactory,
        private readonly ProductPositionRuleCategorySearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
    }

    public function save(ProductPositionRuleCategoryInterface $ruleCategory): ProductPositionRuleCategoryInterface
    {
        try {
            $this->resource->save($ruleCategory);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save product position rule category: %1', $exception->getMessage()),
                $exception
            );
        }

        return $ruleCategory;
    }

    public function getById(int $id): ProductPositionRuleCategoryInterface
    {
        $ruleCategory = $this->ruleCategoryFactory->create();
        $this->resource->load($ruleCategory, $id);

        if (!$ruleCategory->getId()) {
            throw new NoSuchEntityException(__('Product position rule category with ID "%1" does not exist.', $id));
        }

        return $ruleCategory;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): ProductPositionRuleCategorySearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    public function delete(ProductPositionRuleCategoryInterface $ruleCategory): bool
    {
        try {
            $this->resource->delete($ruleCategory);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete product position rule category: %1', $exception->getMessage()),
                $exception
            );
        }

        return true;
    }

    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }

    public function getByCategoryId(int $categoryId): ?ProductPositionRuleCategoryInterface
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('category_id', $categoryId)
            ->setPageSize(1)
            ->create();
        $items = $this->getList($searchCriteria)->getItems();
        if (!$items) {
            return null;
        }

        return reset($items) ?: null;
    }
}
