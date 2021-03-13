<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use App\Http\Resources\ErrorResource;
use App\Repository\AccountRepositoryInterface;
use App\Repository\Error\ErrorRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AccountsController extends Controller
{
    private $accountRepository;
    
    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
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

        if($this->accountRepository->validate($data) == false){
            $error = (new ErrorRepository)->fill([
                'errortype' => 'validation',
                'message' => '',
                'verrors' => $this->accountRepository->verrros,
            ]);
            
            return response(new ErrorResource($error), 422);
        }

        $account = $this->accountRepository->create($data);

        return $account ? new AccountResource($account) : false;
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
        return $this->accountRepository->destroy($id);
    }
}
