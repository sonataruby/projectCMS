<?php namespace App\Models;

use CodeIgniter\Model;


class BillingModel extends Model
{
	protected $table = 'billing';
    protected $primaryKey = 'billing_id';
    protected $language = "en";
    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['invoice_id', 'type', 'status','firstname','lastname','email','phone','address','country','state','zip'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    
    public function create($data){

    }
}