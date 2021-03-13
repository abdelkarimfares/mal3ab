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

    /**
    * Send User Credentials By Email.
    *
    * @param array $credentials
    * @param string $mailTo
    */
    public function sendUserCredentials(array $credentials, $mailTo){

        
    }

    /**
    * Send User Credentials By Email.
    *
    * @param int $id the account id
    * @return bool
    */
    public function deleteUserByAccountId($id): bool{
        $user = $this->model->where('account_id', $id)->first();

        if($user){
            return $user->delete();
        }

        return true;
    }
}