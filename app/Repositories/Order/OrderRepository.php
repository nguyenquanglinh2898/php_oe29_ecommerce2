<?php
namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }

    public function getUserOrders($userId)
    {
        return $this->model->where('user_id', $userId)->orderBy('created_at', 'DESC')
            ->paginate(config('config.paginate'));
    }

    public function getOrderDetail($orderId)
    {
        return $this->model->with(['orderItems.productDeltail.product.user', 'transporter', 'voucher'])->findOrFail($orderId);
    }

    public function getOrderSupplier($order)
    {
        return $order->orderItems->first()->productDeltail->product->user;
    }

    public function showSupplierOrders($supplierId, $status)
    {
        return $this->model->where('status', $status)
            ->whereHas('orderItems.productDeltail.product', function (Builder $query) use ($supplierId) {
                $query->where('user_id', $supplierId);
            })
            ->with('orderItems.productDeltail.product')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function showOrder($orderId)
    {
        return $this->model->with('orderItems', 'transporter', 'voucher')->findOrFail($orderId);
    }

    public function increaseProductRemaining($order)
    {
        $productDetail = [
            'ids' => [],
            'remains' => [],
            'cases' => [],
        ];

        $product = [
            'ids' => [],
            'remains' => [],
            'cases' => [],
        ];

        foreach ($order->orderItems as $orderItem) {
            $productDetail['ids'][] = $orderItem->product_detail_id;
            $productDetail['remains'][] = $orderItem->productDeltail->remaining + $orderItem->quantity;
            $productDetail['cases'][] = "WHEN {$orderItem->product_detail_id} then ?";

            $position = array_search($orderItem->productDeltail->product_id, $product['ids']);
            if ($position) {
                $product['remains'][$position] += $orderItem->quantity;
            } else {
                $product['ids'][] = $orderItem->productDeltail->product_id;
                $product['remains'][] = $orderItem->productDeltail->product->remaining + $orderItem->quantity;
                $product['cases'][] = "WHEN {$orderItem->productDeltail->product_id} then ?";
            }
        }

        $productDetail['ids'] = implode(',', $productDetail['ids']);
        $productDetail['cases'] = implode(' ', $productDetail['cases']);
        $product['ids'] = implode(',', $product['ids']);
        $product['cases'] = implode(' ', $product['cases']);

        $productDetailsUpdateQuery = "UPDATE product_details SET `remaining` = CASE `id` {$productDetail['cases']} END WHERE `id` in ({$productDetail['ids']})";
        $productsUpdateQuery = "UPDATE products SET `remaining` = CASE `id` {$product['cases']} END WHERE `id` in ({$product['ids']})";

        DB::update($productDetailsUpdateQuery, $productDetail['remains']);
        DB::update($productsUpdateQuery, $product['remains']);
    }

    public function updateOrder($order, $attributes = [])
    {
        return $order->update($attributes);
    }
}
