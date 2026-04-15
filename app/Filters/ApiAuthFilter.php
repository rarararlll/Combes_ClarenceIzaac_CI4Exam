<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiAuthFilter implements FilterInterface
{
   public function before(RequestInterface $request, $arguments = null)
{
    $authHeader = $request->getHeaderLine('Authorization');

    if (empty($authHeader) || ! str_starts_with($authHeader, 'Bearer ')) {
        return service('response')
            ->setStatusCode(401)
            ->setJSON([
                'success' => false,
                'message' => 'Access denied. No valid authorization header found.',
            ]);
    }

    $tokenString = trim(substr($authHeader, 7));
    $db          = db_connect();

    // FIXED: changed leftJoin() to join(..., 'left')
    // FIXED: changed $token to $tokenString to match your variable above
    // FIXED: changed $user to $record to match your "if (!$record)" check below
    $record = $db->table('api_tokens t')
        ->select('t.*, u.id as user_id, u.name, u.email, r.name as role_name')
        ->join('users u', 'u.id = t.user_id')
        ->join('roles r', 'r.id = u.role_id', 'left') 
        ->where('t.token', $tokenString)
        ->where('u.deleted_at', null)
        ->get()
        ->getRowArray();

    if (! $record) {
        return service('response')
            ->setStatusCode(401)
            ->setJSON([
                'success' => false,
                'message' => 'Token not recognized. Please log in again.',
            ]);
    }

    if (! empty($record['expires_at']) && strtotime($record['expires_at']) < time()) {
        $db->table('api_tokens')->where('token', $tokenString)->delete();
        return service('response')
            ->setStatusCode(401)
            ->setJSON([
                'success' => false,
                'message' => 'Your token has expired. Please log in again.',
            ]);
    }

    $request->apiUser = $record;
}

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}