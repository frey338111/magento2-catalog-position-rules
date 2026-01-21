<?php

declare(strict_types=1);

namespace Hmh\CatalogPositionRules\Model\Conditions;

use Hmh\CatalogPositionRules\Api\RuleConditionInterface;
use Hmh\CatalogPositionRules\Model\Data\ConditionInfoDto;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Sales\Model\Order;

class SoldLastMonth implements RuleConditionInterface
{
    private const LABEL = 'Sold in past month';
    private const TAG = 'sold_in_past_month';

    public function __construct(
        private readonly ResourceConnection $resourceConnection
    ) {
    }

    public function getLabel(): string
    {
        return self::LABEL;
    }

    public function getTag(): string
    {
        return self::TAG;
    }

    public function isConditionMatch(ProductInterface $product, ConditionInfoDto $condition): bool
    {
        $qtySoldPastMonth = $this->getQtySoldPastMonth((int) $product->getId(), $product->getStoreId());

        return $this->compareQuantity($qtySoldPastMonth, $condition);
    }

    private function getQtySoldPastMonth(int $productId, ?int $storeId = null): float
    {
        $to = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $from = $to->sub(new \DateInterval('P1M'));

        $connection = $this->resourceConnection->getConnection();

        $select = $connection->select()
            ->from(
                ['order_item' => $this->resourceConnection->getTableName('sales_order_item')],
                ['ordered_qty' => 'SUM(order_item.qty_ordered)']
            )
            ->joinInner(
                ['order' => $this->resourceConnection->getTableName('sales_order')],
                'order.entity_id = order_item.order_id',
                []
            )
            ->where('order.state <> ?', Order::STATE_CANCELED)
            ->where('order_item.product_id = ?', $productId)
            ->where('order_item.qty_ordered > ?', 0)
            ->where('order.created_at >= ?', $from->format('Y-m-d H:i:s'))
            ->where('order.created_at <= ?', $to->format('Y-m-d H:i:s'));

        if ($storeId !== null) {
            $select->where('order_item.store_id = ?', $storeId);
        }

        $result = $connection->fetchOne($select);

        return $result !== null ? (float) $result : 0.0;
    }

    private function compareQuantity(float $qtySoldPastMonth, ConditionInfoDto $condition): bool
    {
        $operator = (string) $condition->getOperator();
        $targetValue = (float) $condition->getTargetValue();

        return match ($operator) {
            'gt' => $qtySoldPastMonth > $targetValue,
            'lt' => $qtySoldPastMonth < $targetValue,
            'eq' => $qtySoldPastMonth == $targetValue,
            'ct' => str_contains((string) $qtySoldPastMonth, (string) $condition->getTargetValue()),
            default => false,
        };
    }
}
