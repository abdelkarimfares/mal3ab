<?php
namespace App\Repository\Eloquent;

use App\Repository\Eloquent\BaseRepository;
use App\Repository\TerrainRepositoryInterface;
use App\Models\Terrain;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TerrainRepository extends BaseRepository implements TerrainRepositoryInterface
{
    private $verrros = null;

     /**
    * UserRepository constructor.
    *
    * @param Terrain $model
    */
   public function __construct(Terrain $model)
   {
       parent::__construct($model);
   }

    /**
    * @return Collection
    */
    public function all(): Collection
    {
        return $this->model->all();    
    }
    
    /**
     * @param array the data to validate
    * @return bool the validation status
    */
    public function validate(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'length' => 'nullable|numeric|max:0',
            'width' => 'nullable|numeric|max:0',
            'floor_type' => 'string',
            'city' => 'required|string',
            'adress' => 'required|string',
            'google_latitude' => 'nullable|numeric',
            'google_attitude' => 'nullable|numeric',
            'has_arbite' => 'nullable|boolean',
            'type_terrain_id' => 'exists:type_terrains,id',
            'account_id' => 'exists:accounts,id',
            'thumbnail_id' => 'exists:uploaded_files,id',
            'gallary' => 'nullable|array',
            'gallary.*' => 'exists:uploaded_files,id',
        ]);

        
        if($validator->fails()){
            $this->verrros = $validator->errors()->toArray();
        }
        
        return !$validator->fails();
    }

    /**
    * @param array $attributes
    * @return Terrain|false
    */
    public function create(array $attributes): ?Terrain
    {
        try {

            DB::beginTransaction();

            if(isset($attributes['slug'])){
                $attributes['slug'] = Str::slug($attributes['slug']);
            }
            
            if(isset($attributes['gallary'])){
                $attributes['gallary'] = serialize($attributes['gallary']);
            }

            $terrain = parent::create($attributes);
            DB::commit();
            
            return $terrain;
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return null;
        }

        
    }

    /**
    * @param $filter
    * @return Collection
    */
    public function search(array $filter): Collection
    {
        $query = null;

        if(isset($filter['sort_by']) && $filter['sort_by']){

            $query = Terrain::orderBy($filter['sort_by']);
        }
        else{

            $query = Terrain::orderBy('id');

        }

        if(isset($filter['category']) && $filter['category']){

            $query = Terrain::join('product_categories', 'product_categories.product_id', '=', 'products.id')
                            ->where('product_categories.category_id', $filter['category'])
                            ->select('products.*');
        }


        return $query->with('categories')->get();

    }

    /**
    * @param string $slug
    * @return Terrain
    */
    public function findBySlug($slug): ?Terrain
    {
        return $this->model->where('slug', $slug)->first();
    }
}
