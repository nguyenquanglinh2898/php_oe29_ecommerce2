<?php
namespace App\Repositories\Order;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getUserOrders($userId);

    public function getOrderDetail($orderId);

    public function getOrderSupplier($order);

    public function showSupplierOrders($supplierId, $status);

    public function showOrder($orderId);

    public function increaseProductRemaining($order);

    public function updateOrder($order, $attributes = []);

    public function getFinishedOrdersOfThisMonth($supplierId);

    public function getOrdersByMonth();

    public function getMaxIdOrder();
}
