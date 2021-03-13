<?php
namespace App\Repository\Eloquent;

use App\Http\Resources\AccountResource;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\AccountRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AccountRepository extends BaseRepository implements AccountRepositoryInterface
{
    public $verrros = null;

    const APPROVED = 'approved';
    const DENIED = 'denied';
    const PENDING = 'pending';

    const PACKAGE_BASIC = 'basic';

     /**
    * UserRepository constructor.
    *
    * @param Account $model
    */
   public function __construct(Account $model)
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
    public function validate(array $data, $id = null)
    {
        $validator = Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:accounts,email' . ($id ? ',' . $id :  ''),
            'phone' => 'required|string',
            'adress1' => 'nullable|string',
            'adress2' => 'nullable|string',
            'gender' => 'nullable|string|in:male,female',
            'city' => 'nullable|string',
        ]);

        
        if($validator->fails()){
            $this->verrros = $validator->errors()->toArray();
        }
        
        return !$validator->fails();
    }

    /**
    * @param array $attributes
    * @return Account|NULL
    */
    public function create(array $attributes): ?Account
    {
        
        $userRepository = new UserRepository(new User());

        try {

            DB::beginTransaction();
            
            $attributes['account_status'] = self::PENDING;
            $attributes['status_date'] = now();
            $attributes['package'] = self::PACKAGE_BASIC;
            $account = parent::create($attributes);

            $userRepository->create([
                'name' => $attributes['firstname'] . ' ' . $attributes['lastname'],
                'email' => $account->email,
                'account_id' => $account->id,
                'status' => 1,
                'password' => Hash::make(Str::random(10)),
            ]);
            
            DB::commit();
            
            return $account;
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return null;
        }

        
    }
    
    /**
    * @param int $id
    * @param array $attributes
    * @return Account|NULL
    */
    public function update($id, array $attributes): ?Account
    {
        try {

            DB::beginTransaction();

            $account = $this->model->findOrFail($id);

            $account->firstname = $this->pp($attributes, 'firstname');
            $account->lastname = $this->pp($attributes, 'lastname');
            $account->email = $this->pp($attributes, 'email');
            $account->phone = $this->pp($attributes, 'phone');
            $account->adress1 = $this->pp($attributes, 'adress1', '');
            $account->adress2 = $this->pp($attributes, 'adress2', '');
            $account->gender = $this->pp($attributes, 'gender');
            $account->city = $this->pp($attributes, 'city');

            $account->save();
            DB::commit();
            
            return $account;
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return null;
        }

        
    }

    /**
    * @param $id
    * @return Account
    */
    public function find($id): ?Account
    {
        return parent::find($id);
    }

    /**
    * @param $filter
    * @return Collection
    */
    public function search(array $filter): LengthAwarePaginator
    {
        $query = null;

        $sortby = isset($filter['sort_by']) && in_array($filter['sort_by'], $this->getSortByColumns()) 
                ? $filter['sort_by'] : 'id';

        $search = isset($filter['s']) ? $filter['s'] : '';

        $perpage = isset($filter['perpage']) && is_int($filter['perpage']) ? $filter['perpage'] : 10;

        $query = Account::orderBy($sortby);

        if($search){
            $query = $query->where(function($query) use($search){
                return $query->where('firstname', 'LIKE', "%$search%")
                            ->orWhere('lastname', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%")
                            ->orWhere('phone', 'LIKE', "%$search%")
                            ->orWhere('city', 'LIKE', "%$search%");
            });
        }

        return $query->paginate($perpage);

    }

    public function getSortByColumns(){
        return [
        'firstname',
        'lastname',
        'email',
        'phone',
        'city'
        ];
    }
}
