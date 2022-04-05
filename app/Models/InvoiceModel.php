<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\InvoiceItemModel;

class InvoiceModel extends Model
{
	protected $table = 'invoice';
    protected $primaryKey = 'inc_id';
   
    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name','firstname', 'lastname','email','cost','discord','discordline','payment','status','return_action'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function createInvoice($arv=[], $item=[]){
        
        $arv["auth_id"] = user_id();
        $this->insert($arv);
        $invoice_id = $this->insertID();

        if(is_array($item)){
            $dbitem = new InvoiceItemModel;
            $dbitem->createItem($invoice_id,$item);
        }
        return $invoice_id;
    }

    public function getInvoice($inc_id){
        $data = $this->where("inc_id",$inc_id)->first();
        $dbitem = new InvoiceItemModel;
        $data->item = $dbitem->getItemInvoice($invoice_id);
        return $data;
    }
    

    public function getMyInvoice($inc_id){
        return $this->where("auth_id",user_id())->findAll();
    }

    public function removeMyInvoice($inc_id){
        $dbitem = new InvoiceItemModel;
        $dbitem->clearItemInvoice($inc_id);
        return $this->where("auth_id",user_id())->delete($inc_id);
    }
}