<?php

namespace VSApi\Classes;

class Api
{

    public static function response($data = [], string $message = 'Operation was successful!', array $meta = [],  $status = 200)
    {
        return self::response([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => $meta,
        ], $status);
    }

}
