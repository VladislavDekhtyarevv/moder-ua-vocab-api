<?php

namespace App\Services;

use App\Models\Word;

final class WordService
{
    public function create($data, $user)
    {
        try {
            $user->words()->create($data->all());
            return true;
        }catch (\Throwable $e) {
            return false;
        }

    }
}
