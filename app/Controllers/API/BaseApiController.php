<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class BaseApiController extends ResourceController
{
    protected $format = 'json';

    protected function respondSuccess($data = null, string $msg = 'OK', int $code = 200)
    {
        return $this->response->setStatusCode($code)->setJSON([
            'success' => true,
            'message' => $msg,
            'data'    => $data,
        ]);
    }

    protected function respondFail(string $msg = 'Something went wrong.', int $code = 400)
    {
        return $this->response->setStatusCode($code)->setJSON([
            'success' => false,
            'message' => $msg,
        ]);
    }
}