<?php
namespace App\Repository;

use App\Models\Terrain;
use Illuminate\Support\Collection;

interface TerrainRepositoryInterface
{
    /**
    * @return Collection
    */
    public function all(): Collection;

    /**
    * @param array $attributes
    *
    * @return Terrain
    */
    public function create(array $attributes): ?Terrain;

    /**
    * @param $id
    * @return Terrain
    */
    public function find($id): ?Terrain;

    /**
    * @param $id
    * @return bool
    */
    public function destroy($id): bool;

    /**
    * @param $id
    * @return array or bool
    */
    public function validate(array $data);

    /**
    * @param $filter
    * @return Collection
    */
    public function search(array $filter): Collection;

    /**
    * @param string $slug
    * @return Terrain
    */
    public function findBySlug($slug): ?Terrain;
}