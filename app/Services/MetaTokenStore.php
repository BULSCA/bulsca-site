<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;

/** Private, encrypted state shared by the scheduler and PHP containers. */
class MetaTokenStore
{
    public function get(): ?string
    {
        $path = config('services.meta.token_path');
        if (! is_file($path)) return config('services.meta.access_token') ?: null;
        try {
            $data = json_decode(Crypt::decryptString(file_get_contents($path)), true, flags: JSON_THROW_ON_ERROR);
            if (! is_string($data['access_token'] ?? null) || ! is_int($data['expires_at'] ?? null)) throw new \RuntimeException();
            return $data['expires_at'] > time() ? $data['access_token'] : null;
        } catch (\Throwable) {
            throw new \RuntimeException('Stored social credentials unavailable');
        }
    }

    public function put(string $token, int $expiresIn): void
    {
        if ($token === '' || $expiresIn <= 0) throw new \InvalidArgumentException('Invalid social credentials');
        $path = config('services.meta.token_path');
        $directory = dirname($path);
        if (! is_dir($directory) && ! mkdir($directory, 0700, true) && ! is_dir($directory)) throw new \RuntimeException('Social credential storage unavailable');
        $temporary = tempnam($directory, '.meta-');
        if ($temporary === false) throw new \RuntimeException('Social credential storage unavailable');
        try {
            $encrypted = Crypt::encryptString(json_encode(['access_token' => $token, 'expires_at' => time() + $expiresIn], JSON_THROW_ON_ERROR));
            if (! chmod($temporary, 0600) || file_put_contents($temporary, $encrypted, LOCK_EX) === false || ! rename($temporary, $path)) throw new \RuntimeException('Social credential storage unavailable');
        } finally {
            if (is_file($temporary)) unlink($temporary);
        }
    }
}
