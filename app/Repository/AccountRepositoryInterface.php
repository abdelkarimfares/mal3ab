<?php
namespace App\Repository;

use App\Models\Account;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface AccountRepositoryInterface
{
    /**
    * @return Collection
    */
    public function all(): Collection;

    /**
    * @param array $attributes
    *
    * @return Account
    */
    public function create(array $attributes): ?Account;

    /**
    * @param $id
    * @return Account
    */
    public function find($id): ?Account;

    /**
    * @param $id
    * @return bool
    */
    public function destroy($id): bool;

    /**
    * @param $id
    * @return bool the validation status
    */
    public function validate(array $data, $id = null);

    /**
    * @param $filter
    * @return LengthAwarePaginator
    */
    public function search(array $filter): LengthAwarePaginator;

    /**
    * @param int $id
    * @param array $attributes
    * @return Account|NULL
    */
    public function update($id, array $attributes): ?Account;
    
}