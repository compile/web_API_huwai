<?php

namespace app\admin\controller;

class Error
{
    public function __call($method, $args)
    {
        return 'error request!';
    }
}