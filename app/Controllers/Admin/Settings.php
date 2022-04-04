<?php

namespace App\Controllers\Admin;
use App\Models\SettingsModel;
class Settings extends AdminController
{
    protected $db;
    public function __construct(){
        $this->db = new SettingsModel;
        parent::__construct();
    }
    public function index()
    {
        $data = $this->db->exportConfig("");

        return view('admin/settings',["data" => $data]);
    }
    public function config(){
        $data = $this->request->getPost("config");
        
        foreach ($data as $key => $value) {

           $this->db->saveSettingsByKey($key, $value);
        }
        $this->db->exportConfig("config.json");
        return _go("/admin/settings");
    }
}
