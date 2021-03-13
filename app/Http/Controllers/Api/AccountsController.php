<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use App\Http\Resources\ErrorResource;
use App\Repository\AccountRepositoryInterface;
use App\Repository\Error\ErrorRepository;
use App\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountsController extends Controller
{
    private $accountRepository;
    private $userRepository;
    
    public function __construct(AccountRepositoryInterface $accountRepository, UserRepositoryInterface $userRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->userRepository = $userRepository;
    }

    /**
    * @return ResourceCollection return collection of accounts
    */
    public function index(Request $request): ResourceCollection
    {
        return AccountResource::collection($this->accountRepository->search($request->all(), 10));
    }

    /**
     * @param $id the id of Account
    * @return Account|null Show Account Data
    */
    public function show($id)
    {
        $account = $this->accountRepository->find($id);
        
        return $account ? new AccountResource($account) : null;
    }

    /**
     * @param Account $request the request data
    * @return Account|null Show Account Data
    */
    public function create(Request $request)
    {
        $data = $request->all();
        $response = [];


        if($this->accountRepository->validate($data) == false){
            $error = (new ErrorRepository)->fill([
                'errortype' => 'validation',
                'message' => '',
                'verrors' => $this->accountRepository->verrros,
            ]);
            
            return response(new ErrorResource($error), 422);
        }

        $account = $this->accountRepository->create($data);

        if($account){
            $response['account'] = new AccountResource($account);
            
            $user_password = Str::random(10);
            
            $user = $this->userRepository->create([
                'name' => $data['firstname'] . ' ' . $data['lastname'],
                'email' => $account->email,
                'account_id' => $account->id,
                'status' => 1,
                'password' => Hash::make($user_password),
                'email_verified_at' => now(),
            ]);
            
            $credentials = [
                'email' => $user->email,
                'password' => $user_password,
            ];

            // Send Mail
            $this->userRepository->sendUserCredentials($credentials, $account->email);

            $response['credentials'] = $credentials;
        }
        else{
            $response = false;
        }


        return $response;
    }

    /**
     * @param Account $request the request data
    * @return Account|null Show Account Data
    */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if($this->accountRepository->validate($data, $id) == false){
            $error = (new ErrorRepository)->fill([
                'errortype' => 'validation',
                'message' => '',
                'verrors' => $this->accountRepository->verrros,
            ]);
            
            return response(new ErrorResource($error), 422);
        }

        $account = $this->accountRepository->update($id, $data);

        return $account ? new AccountResource($account) : false;
    }

    /**
     * @param $id the id of Account
    * @return bool return true if the account delete
    */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $deleted = $this->accountRepository->destroy($id);

            if($deleted){
                $deleted = $this->userRepository->deleteUserByAccountId($id);
            }

            if(!$deleted ){
                DB::rollBack();
            }else{
                DB::commit();
            }

            return $deleted;
            
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        return false;
    }
}
