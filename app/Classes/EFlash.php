<?php

namespace App\Classes;

class EFlash
{
    /**
     * @var \Laracasts\Flash\FlashNotifier
     */
    protected $notifier;

    public function __construct()
    {
        $this->notifier = app('flash');
    }

    public function message($format, $level, ...$args)
    {
        $escapedArgs = array_map(function ($arg) {
            return e($arg);
        }, $args);

        $message = sprintf($format, ...$escapedArgs);

        return $this->notifier->message($message, $level);
    }

    public function success($format, ...$args)
    {
        return $this->message($format, 'success', ...$args);
    }

    public function error($format, ...$args)
    {
        return $this->message($format, 'danger', ...$args);
    }

    public function info($format, ...$args)
    {
        return $this->message($format, 'info', ...$args);
    }

    public function warning($format, ...$args)
    {
        return $this->message($format, 'warning', ...$args);
    }
}
