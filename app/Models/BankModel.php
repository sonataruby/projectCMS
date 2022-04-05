<?php namespace App\Models;

use CodeIgniter\Model;


class BankModel extends Model
{
	protected $table = 'users_bank';
    protected $primaryKey = 'bank_id';
    protected $language = "en";
    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['auth_id', 'balance', 'status'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function getBalance(){
        $auth_id = user_id();
        if(!$auth_id == 0) return 0;
        $this->where("auth_id",$auth_id);
        $this->where("status","Online");
        $data = $this->first();
        return $data->balance;
    }

    public function setBalance($cost=0){
        $auth_id = user_id();
        if(!$auth_id == 0 || $cost == 0) return 0;
        $this->where("auth_id",$auth_id);
        $this->where("status","Online");
        $info  = $this->first();
        if($info){
            $this->update(["bank_id" => $info->bank_id],["balance" => $info->balance + $cost]);
        }else{
            $this->insert(["balance" => $cost, "auth_id" => $auth_id, "status" => "Online"]);
        }
    }
    
}