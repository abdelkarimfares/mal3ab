<?php
namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function create(array $attributes): User; 
    
    /**
    * Send User Credentials By Email.
    *
    * @param array $credentials
    * @param string $mailTo
    */
    public function sendUserCredentials(array $credentials, $mailTo);
    
    /**
    * Send User Credentials By Email.
    *
    * @param int $id the account id
    * @return bool
    */
    public function deleteUserByAccountId($id) : bool;
}