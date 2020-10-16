<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MX_Controller
{

    public function __construct()
    {  if( ! $this->ion_auth->logged_in() )
            redirect('admin/login');


        if( ! $this->ion_auth_acl->has_permission('admin_access') )
            return show_error("You must be an administrator to view this page");
	        parent::__construct();
        $this->load->model('page_model');
        $this->load->library('functions');

    }

    public function index($msg = "", $type = "")
    {
        $this->load->library('pagination');
        
            $offset = $this->input->get("per_page");
            $jsinc = array('plugins.js');


            if ($offset <= 0)
                $offset = 0;

            $data = array(
                'pages' => $this->page_model->get_pages(),
                'jsinc' => $jsinc,
                'msg' => $this->functions->show_msg($msg, $type)

            );

            $config['base_url'] = base_url() . 'page/index';
            $config['total_rows'] = 3;
            $config['per_page'] = 3;
            $config['page_query_string'] = TRUE;

            $this->pagination->initialize($config);

            $this->load->view('page_list', $data);

        
    }

    public function add_page(){
        
            $this->load->view('add_page');
        
    }

    public function edit_page($id){
        
            $data['page'] = $this->page_model->get_page($id);
            $this->load->view('add_page',$data);
        
    }

    public function delete_page($id){
            $data['page'] = $this->page_model->delete_page($id);
            redirect("page");
        
    }

    public function save_page(){
        $text = $_REQUEST['page'];
        $title = (strlen($_REQUEST['title']) > 0) ? $_REQUEST['title'] : "No Title";
        $safi = $this->safisha($text);
        $data['title'] = $title;
        $data['content'] = $safi;
        $data['original'] = "<db>".$text."</db>";

        $this->page_model->add_page($data);
        //$data['safi'] = $safi;
        //$this->load->view('page_list',$data);
    }
    public function update_page($id){
        $text = $_REQUEST['page'];
        $title = (strlen($_REQUEST['title']) > 0) ? $_REQUEST['title'] : "No Title";
        $safi = $this->safisha($text);
        $data['title'] = $title;
        $data['content'] = $safi;
        $data['original'] = "<db>".$text."</db>";

        $this->page_model->update_page($id,$data);
        //$data['safi'] = $safi;
        //$this->load->view('page_list',$data);
    }

    function  show_text($id){
        $data['page'] = $this->page_model->get_page($id);
        $this->load->view('preview', $data);
    }

    public function safisha($text){
        $text_safi = $this->functions->strip_tags_content($text, '<info>', TRUE);
        $text_safi = preg_replace ('/id="keditor-(.+?)"/', '', $text_safi);
        $text_safi = preg_replace ('/class="keditor-(.+?)"/', '', $text_safi);
        $text_safi = preg_replace ('/<div >   <a(.+?)<.div./', '', $text_safi);
        return $text_safi;
    }

}