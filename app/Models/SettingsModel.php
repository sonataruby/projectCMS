<?php namespace App\Models;

use CodeIgniter\Model;


class SettingsModel extends Model
{
	protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $language = "en";
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['settings_key', 'settings_value','language','globals'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct(){
    	$this->language = service('request')->getLocale();
        parent::__construct();
    }


    public function saveSettingsByKey($key, $value, $global="Yes"){
    	$db = $this->where(["settings_key" => $key, "language" => $this->language])->first();
    	if(!$db){
    		$this->insert(["settings_key" => $key, "settings_value" => $value, "language" => $this->language, "globals" => $global]);
    	}else{
            
    		$this->update(["id" => $db["id"]],["settings_value" => $value, "globals" => $global]);
    	}
    	
    }

    public function exportConfig($file=""){
    	$db = $this->where(["language" => $this->language])->findAll();
    	$arv = [];
    	foreach($db as $k => $v){
    		$arv[$v["settings_key"]] = $v["settings_value"];
    	}
    	if($file != "")file_put_contents(FCPATH. "/config.json", json_encode($arv));
    	return json_decode(json_encode($arv));
    }
}