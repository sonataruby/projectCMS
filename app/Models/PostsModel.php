<?php namespace App\Models;

use CodeIgniter\Model;


class PostsModel extends Model
{
	protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $language = "en";
    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['url', 'type', 'name','description','contents','images','auth_id','tags','category_id','permissions','status','language'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct(){
    	$this->language = service('request')->getLocale();
        $this->where("language",$this->language);
        parent::__construct();
    }

    public function getPost($page, $number, $search=""){
        $this->where("language",$this->language);
        return $this->findAll($page, $number);
    }

    public function getPostsByType($type,$page=0, $number=20,$search=''){
        $this->where("language",$this->language);
        $this->where("type",$type);
        return $this->findAll($page,$number);
    }

    public function getPostByID($id){
        $this->where("language",$this->language);
        $this->where("id",$id);
        return $this->first();
    }

    public function getPostByURL($url){
        $this->where("language",$this->language);
        $this->where("url",$url);
        return $this->first();
    }

    public function getPostByAuth($auth_id,$page=0, $number=20,$search=''){
        //$this->where("language",$this->language);
        $this->where("auth_id",$auth_id);
        return $this->findAll($page,$number);
    }

    public function createPosts($arv=[]){
        $arv["language"] = $this->language;
        $arv["auth_id"] = user_id();
        $arv["contents"] = trim($arv["contents"]);
        $this->insert($arv);
    }

    public function updatePosts($id,$arv=[]){
        $this->where("auth_id",user_id());
        $arv["contents"] = trim($arv["contents"]);
        $this->update($id,$arv);
    }

    public function deletePosts($id){
        $this->where("auth_id",user_id());

        $this->delete($id);
    }


    
}