<?php

if (!function_exists('statusOrder')) {
    function statusOrder($status)
    {
        if ($status == config('config.order_status_cancel')) {

            return config('config.order_status_cancel_name');
        }
        if ($status == config('config.order_status_refuse')) {

            return config('config.order_status_refuse_name');
        }
        if ($status == config('config.order_status_pending')) {

            return config('config.order_status_pending_name');
        }
        if ($status == config('config.order_status_accept')) {

            return config('config.order_status_accept_name');
        }
        if ($status == config('config.order_status_finish')) {

            return config('config.order_status_finish_name');
        }
    }
}

if (!function_exists('classOrder')) {
    function classOrder($status)
    {
        if ($status == config('config.order_status_cancel')) {

            return config('config.order_status_cancel_class');
        }
        if ($status == config('config.order_status_refuse')) {

            return config('config.order_status_refuse_class');
        }
        if ($status == config('config.order_status_pending')) {

            return config('config.order_status_pending_class');
        }
        if ($status == config('config.order_status_accept')) {

            return config('config.order_status_accept_class');
        }
        if ($status == config('config.order_status_finish')) {

            return config('config.order_status_finish_class');
        }
    }
}

if (!function_exists('iconOrder')) {
    function iconOrder($status)
    {
        if ($status == config('config.order_status_cancel')) {

            return config('config.order_status_cancel_icon');
        }
        if ($status == config('config.order_status_refuse')) {

            return config('config.order_status_refuse_icon');
        }
        if ($status == config('config.order_status_pending')) {

            return config('config.order_status_pending_icon');
        }
        if ($status == config('config.order_status_accept')) {

            return config('config.order_status_accept_icon');
        }
        if ($status == config('config.order_status_finish')) {

            return config('config.order_status_finish_icon');
        }
    }
}

if (!function_exists('statusSupplier')) {
    function statusSupplier($status)
    {
        if ($status == config('config.status_block')) {

            return config('config.status_block_name');
        }
        if ($status == config('config.status_active')) {

            return config('config.status_active_name');
        }
        if ($status == config('config.status_not_active')) {

            return config('config.status_not_active_name');
        }
    }
}

if (!function_exists('classSupplier')) {
    function classSupplier($status)
    {
        if ($status == config('config.status_block')) {

            return config('config.status_block_class');
        }
        if ($status == config('config.status_active')) {

            return config('config.status_active_class');
        }
        if ($status == config('config.status_not_active')) {

            return config('config.status_not_active_class');
        }
    }
}

if (!function_exists('iconSupplier')) {
    function iconSupplier($status)
    {
        if ($status == config('config.status_block')) {

            return config('config.order_status_refuse_icon');
        }
        if ($status == config('config.status_not_active')) {

            return config('config.order_status_pending_icon');
        }
        if ($status == config('config.status_active')) {

            return config('config.order_status_finish_icon');
        }
    }
}

?>
