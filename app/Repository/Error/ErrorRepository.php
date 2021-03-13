<?php
namespace App\Repository\Error;

use App\Repository\ErrorRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorRepository implements ErrorRepositoryInterface
{
    public $errortype;
    public $message;
    public $verrors;

    /**
    * @param array
    * @return mixed
    */
    public function fill($data): ErrorRepository
    {
        $this->errortype = isset($data['errortype']) ? $data['errortype'] : 'anonymose';
        $this->message = isset($data['message']) ? $data['message'] : '';
        $this->verrors = isset($data['verrors']) ? $data['verrors'] : [];


        return $this;
    }

     
}
