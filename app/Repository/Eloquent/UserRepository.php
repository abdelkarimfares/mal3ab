<?php
namespace App\Repository\Eloquent;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
    * UserRepository constructor.
    *
    * @param User $model
    */
   public function __construct(User $model)
   {
       parent::__construct($model);
   }

    public function create(array $attributes): User{

        return parent::create($attributes);



    }
}