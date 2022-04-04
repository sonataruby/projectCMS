<?php namespace App\Models;

use CodeIgniter\Model;


class TraderReportModel extends Model
{
	protected $table = 'trader_report';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['sl_total', 'sl_total_pips','tp_total','tp_total_pips','tp_total_vip_pips','usd_total','stock_symbol','forex_symbol','crypto_symbol'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}