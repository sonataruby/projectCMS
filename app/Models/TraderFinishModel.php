<?php namespace App\Models;

use CodeIgniter\Model;


class TraderFinishModel extends Model
{
	protected $table = 'trader_signal_finish';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['signals_id', 'type','symbol','open','opentime','sl','close_at','close_time','profit_pip','profit_usd','close_type','message_id','is_access','daily','weekly'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}