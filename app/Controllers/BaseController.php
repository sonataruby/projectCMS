<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\InvoiceModel;
use App\Models\PostsModel;
/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ["auth","date"];
    protected $invoice;
    protected $posts;
    protected $pages;
    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        $request->config = json_decode(file_get_contents(FCPATH."/config.json"));
        $this->invoice = new InvoiceModel;
        $this->posts = new PostsModel;
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    public function getHeader($arv=[]){
        $this->request->config->title = $this->request->config->site_name;
        $this->request->config->description = $this->request->config->site_description;
        $this->request->config->keywords = $this->request->config->site_keyword;
        $this->request->config->image = $this->request->config->site_image;
        $this->request->config->icon = $this->request->config->site_icon;
        $this->request->config->tiwter = $this->request->config->site_tiwter;
        $this->request->config->facebook = $this->request->config->site_facebook;

        $data = array_merge((Array)$this->request->config, $arv);

        return $data;
    }

    public function getNav(){
        
    }
}
