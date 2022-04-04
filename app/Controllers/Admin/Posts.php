<?php
namespace App\Controllers\Admin;
use App\Models\PostsModel;
class Posts extends AdminController
{
    protected $db;
    public function __construct(){
        $this->db = new PostsModel;
        parent::__construct();
    }

    public function index()
    {
        $data = $this->db->getPost(0,20);

        return view('admin/posts',["data" => $data]);
    }


    public function manager($id=0){
        $data = [];
        if($id > 0) $data = $this->db->find($id);
        return view('admin/posts_form',["data" => $data]);
    }

    public function createdata($id=0){
        
        $data = $this->request->getPost("form");
        if($id > 0){
            $this->db->updatePosts($id, $data);
        }else{
            $this->db->createPosts($data);
        }
        return _go("/admin/posts");
        
    }
    

    public function delete($id=0){
        
        $this->db->deletePosts($id);
        return _go("/admin/posts");
        
    }

}
