<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Ui\DataProvider;

use Hmh\CatalogPositionRules\Api\ProductPositionRuleRepositoryInterface;
use Hmh\CatalogPositionRules\Model\ResourceModel\ProductPositionRule\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Ui\DataProvider\AbstractDataProvider;

class ProductPositionRuleFormDataProvider extends AbstractDataProvider
{
    private array $loadedData = [];

    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        private readonly ProductPositionRuleRepositoryInterface $repository,
        private readonly CollectionFactory $collectionFactory,
        private readonly RequestInterface $request,
        private readonly DataPersistorInterface $dataPersistor,
        private readonly Json $jsonSerializer,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData(): array
    {
        if ($this->loadedData) {
            return $this->loadedData;
        }

        $data = $this->dataPersistor->get('hmh_catalog_position_rules_form');
        if (!empty($data)) {
            $this->loadedData[0] = $data;
            $this->dataPersistor->clear('hmh_catalog_position_rules_form');
            return $this->loadedData;
        }

        $id = (int)$this->request->getParam($this->getRequestFieldName());
        if ($id) {
            try {
                $rule = $this->repository->getById($id);
                $this->loadedData[$id] = $rule->getData();

                $rulesData = $rule->getRule();
                if (is_string($rulesData)) {
                    try {
                        $rulesData = $this->jsonSerializer->unserialize($rulesData);
                    } catch (\InvalidArgumentException $exception) {
                        $rulesData = [];
                    }
                }

                $this->loadedData[$id]['product_ranking_rules'] = $rulesData;

            } catch (\Exception $exception) {
                return $this->loadedData;
            }
        }

        return $this->loadedData;
    }
}
