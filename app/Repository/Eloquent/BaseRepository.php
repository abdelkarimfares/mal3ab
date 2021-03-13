<?php   

namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface; 
use Illuminate\Database\Eloquent\Model;   

class BaseRepository implements EloquentRepositoryInterface 
{     
    /**      
     * @var Model      
     */     
     protected $model;       

    /**      
     * BaseRepository constructor.      
     *      
     * @param Model $model      
     */     
    public function __construct(Model $model)     
    {         
        $this->model = $model;
    }
 
    /**
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): ?Model
    {
        return $this->model->create($attributes);
    }
 
    /**
    * @param $id
    * @return Model
    */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }
    
    /**
    * @param $id
    * @return bool
    */
    public function destroy($id): bool
    {
        return $this->model->destroy($id);
    }

    protected function pp($arr, $key, $default = null){
        return isset($arr[$key]) ? $arr[$key] : $default;
    }
}