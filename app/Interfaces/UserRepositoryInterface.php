<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function paginate(array $input);
}
