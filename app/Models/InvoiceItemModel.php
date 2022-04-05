<?php namespace App\Models;

use CodeIgniter\Model;


class InvoiceItemModel extends Model
{
	protected $table = 'invoice_item';
    protected $primaryKey = 'item_id';
   
    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['inc_id','name','price','qty', 'discord','payment'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function createItem($inc_id=0, $arv=[]){
        if($inc_id == 0 || !is_array($arv)) return false;
        foreach ($arv as $key => $value) {
            if(is_array($value)){
                $inser_db = array_merge($value,["inc_id" => $inc_id]);
                $this->insert($inser_db);
            }
            
        }
    }


    public function getItemInvoice($inc_id){
        $this->where("inc_id",$inc_id);
        return $this->findAll();
    }

    public function clearItemInvoice($inc_id)
    {
        $this->where("inc_id",$inc_id);
        $this->delete();
    }
}
