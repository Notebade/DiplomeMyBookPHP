<?php
declare(strict_types=1);

namespace App;

trait Wrapper
{
    public function success(): array
    {
        return [
            'status' => true
        ];
    }

    public function failed(string $e): array
    {
        return [
            'status' => false,
            'message' => $e
        ];
    }
}
