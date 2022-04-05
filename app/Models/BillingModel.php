<?php namespace App\Models;

use CodeIgniter\Model;


class BillingModel extends Model
{
	protected $table = 'billing';
    protected $primaryKey = 'id';
    protected $language = "en";
    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['invoice_id', 'type', 'status'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    
}