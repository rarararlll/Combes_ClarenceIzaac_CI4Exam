<?php

namespace App\Controllers\Api;

use App\Models\TokenModel;
use App\Models\UserModel;

class AuthController extends BaseApiController
{
    // Token valid for 24 hours
    private const EXPIRY_SECONDS = 86400;

    // POST /api/v1/auth/token
    public function issueToken()
    {
        $email    = $this->request->getJsonVar('email')    ?? $this->request->getPost('email');
        $password = $this->request->getJsonVar('password') ?? $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            return $this->respondFail('Both email and password are required.', 400);
        }

        $userModel = new UserModel();
        $user      = $userModel->findByEmail($email);

        if (! $user || ! password_verify($password, $user['password'])) {
            return $this->respondFail('Credentials do not match our records.', 401);
        }

        $newToken  = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + self::EXPIRY_SECONDS);

        (new TokenModel())->saveToken($user['id'], $newToken, $expiresAt);

        return $this->respondSuccess([
            'token'      => $newToken,
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt,
            'user' => [
    'id'    => $user['id'],
    'name'  => $user['fullname'] ?? $user['name'] ?? 'Unknown',
    'email' => $user['username'] ?? $user['email'] ?? '',
],
        ], 'Login successful. Token issued.', 201);
    }

    // DELETE /api/v1/auth/token
    public function revokeToken()
    {
        $header = $this->request->getHeaderLine('Authorization');
        $token  = trim(substr($header, 7));

        (new TokenModel())->removeToken($token);

        return $this->respondSuccess(null, 'You have been logged out. Token removed.');
    }
}