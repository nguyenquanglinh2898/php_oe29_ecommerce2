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

            return config('config.order_status_refuse.class');
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

?>
