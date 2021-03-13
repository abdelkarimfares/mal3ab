<?php
namespace App\Repository;

use App\Repository\Error\ErrorRepository;

interface ErrorRepositoryInterface
{
    /**
    * @param array
    * @return mixed
    */
    public function fill($data): ErrorRepository;

}