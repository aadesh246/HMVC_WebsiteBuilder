<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');


		}

	public function index()
	{ 
		if( ! $this->ion_auth->logged_in() )
            redirect('admin/login');


        if( ! $this->ion_auth_acl->has_permission('admin_access') )
            return show_error("You must be an administrator to view this page");
	
		
		$this->load->view("index");
	}
	public function users()
    {if( ! $this->ion_auth->logged_in() )
            redirect('admin/login');


        if( ! $this->ion_auth_acl->has_permission('admin_access') )
            return show_error("You must be an administrator to view this page");
	
        $data['users']  =   $this->ion_auth->users()->result();

        $this->load->view('users', $data);
    }

    public function manage_user()
    {
        $user_id  =   $this->uri->segment(3);
if( ! $this->ion_auth->logged_in() )
            redirect('admin/login');


        if( ! $this->ion_auth_acl->has_permission('admin_access') )
            return show_error("You must be an administrator to view this page");
	
        if( ! $user_id )
        {
            $this->session->set_flashdata('message', "No user ID passed");
            redirect("admin/users", 'refresh');
        }

        $data['user']               =   $this->ion_auth->user($user_id)->row();
        $data['user_groups']        =   $this->ion_auth->get_users_groups($user_id)->result();
        $data['user_acl']           =   $this->ion_auth_acl->build_acl($user_id);

        $this->load->view('manage_user', $data);
    }

	public function user_permissions()
    {
    	if( ! $this->ion_auth->logged_in() )
            redirect('admin/login');


        if( ! $this->ion_auth_acl->has_permission('admin_access') )
            return show_error("You must be an administrator to view this page");
	
		

        $user_id  =   $this->uri->segment(3);

        if( ! $user_id )
        {
            $this->session->set_flashdata('message', "No user ID passed");
            redirect("admin/users", 'refresh');
        }

        if( $this->input->post() && $this->input->post('cancel') )
            redirect("admin/manage-user/{$user_id}", 'refresh');


        if( $this->input->post() && $this->input->post('save') )
        {
            foreach($this->input->post() as $k => $v)
            {
                if( substr($k, 0, 5) == 'perm_' )
                {
                    $permission_id  =   str_replace("perm_","",$k);

                    if( $v == "X" )
                        $this->ion_auth_acl->remove_permission_from_user($user_id, $permission_id);
                    else
                        $this->ion_auth_acl->add_permission_to_user($user_id, $permission_id, $v);
                }
            }

            redirect("admin/manage_user/{$user_id}", 'refresh');
        }

        $user_groups    =   $this->ion_auth_acl->get_user_groups($user_id);

        $data['user_id']                =   $user_id;
        $data['permissions']            =   $this->ion_auth_acl->permissions('full', 'perm_key');
        $data['group_permissions']      =   $this->ion_auth_acl->get_group_permissions($user_groups);
        $data['users_permissions']      =   $this->ion_auth_acl->build_acl($user_id);

        $this->load->view('admin/user_permissions', $data);
    }
     public function group_permissions()
    {
        if( $this->input->post() && $this->input->post('cancel') )
            redirect('admin/groups', 'refresh');

        $group_id  =   $this->uri->segment(3);

        if( ! $group_id )
        {
            $this->session->set_flashdata('message', "No group ID passed");
            redirect("admin/groups", 'refresh');
        }

        if( $this->input->post() && $this->input->post('save') )
        {
            foreach($this->input->post() as $k => $v)
            {
                if( substr($k, 0, 5) == 'perm_' )
                {
                    $permission_id  =   str_replace("perm_","",$k);

                    if( $v == "X" )
                        $this->ion_auth_acl->remove_permission_from_group($group_id, $permission_id);
                    else
                        $this->ion_auth_acl->add_permission_to_group($group_id, $permission_id, $v);
                }
            }

            redirect('admin/groups', 'refresh');
        }

        $data['permissions']            =   $this->ion_auth_acl->permissions('full', 'perm_key');
        $data['group_permissions']      =   $this->ion_auth_acl->get_group_permissions($group_id);

        $this->load->view('admin/group_permissions', $data);
    }
	 public function permissions()
    {
    	if( ! $this->ion_auth->logged_in() )
            redirect('admin/login');


        if( ! $this->ion_auth_acl->has_permission('admin_access') )
            return show_error("You must be an administrator to view this page");
	
        $data['permissions']    =   $this->ion_auth_acl->permissions('full');

        $this->load->view('permissions', $data);
    }
public function add_permission()
    { if( ! $this->ion_auth->logged_in() )
            redirect('admin/login');


        if( ! $this->ion_auth_acl->has_permission('admin_access') )
            return show_error("You must be an administrator to view this page");
	
        if( $this->input->post() && $this->input->post('cancel') )
            redirect('admin/permissions', 'refresh');

        $this->form_validation->set_rules('perm_key', 'key', 'required|trim');
        $this->form_validation->set_rules('perm_name', 'name', 'required|trim');

        $this->form_validation->set_message('required', 'Please enter a %s');

        if( $this->form_validation->run() === FALSE )
        {
            $data['message'] = ($this->ion_auth_acl->errors() ? $this->ion_auth_acl->errors() : $this->session->flashdata('message'));

            $this->load->view('add_permission', $data);
        }
        else
        {
            $new_permission_id = $this->ion_auth_acl->create_permission($this->input->post('perm_key'), $this->input->post('perm_name'));
            if($new_permission_id)
            {
                // check to see if we are creating the permission
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/permissions", 'refresh');
            }
        }
    }

    public function update_permission()
    { if( ! $this->ion_auth->logged_in() )
            redirect('admin/login');


        if( ! $this->ion_auth_acl->has_permission('admin_access') )
            return show_error("You must be an administrator to view this page");
	
        if( $this->input->post() && $this->input->post('cancel') )
            redirect('admin/permissions', 'refresh');

        $permission_id  =   $this->uri->segment(3);

        if( ! $permission_id )
        {
            $this->session->set_flashdata('message', "No permission ID passed");
            redirect("admin/permissions", 'refresh');
        }

        $permission =   $this->ion_auth_acl->permission($permission_id);

        $this->form_validation->set_rules('perm_key', 'key', 'required|trim');
        $this->form_validation->set_rules('perm_name', 'name', 'required|trim');

        $this->form_validation->set_message('required', 'Please enter a %s');

        if( $this->form_validation->run() === FALSE )
        {
            $data['message']    = ($this->ion_auth_acl->errors() ? $this->ion_auth_acl->errors() : $this->session->flashdata('message'));
            $data['permission'] = $permission;

            $this->load->view('edit_permission', $data);
        }
        else
        {
            $additional_data    =   array(
                'perm_name' =>  $this->input->post('perm_name')
            );

            $update_permission = $this->ion_auth_acl->update_permission($permission_id, $this->input->post('perm_key'), $additional_data);
            if($update_permission)
            {
                // check to see if we are creating the permission
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/permissions", 'refresh');
            }
        }
    }

	function login()
	{
		$this->data['title'] = $this->lang->line('login_heading');

		//validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() == true)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page

				$this->session->set_flashdata('message', $this->ion_auth->messages());
			     
				redirect('/', 'refresh');
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id'   => 'password',
				'type' => 'password',
			);

			$this->_render_page('login', $this->data);
		}
	}
	public function groups()
    { if( ! $this->ion_auth->logged_in() )
            redirect('admin/login');


        if( ! $this->ion_auth_acl->has_permission('admin_access') )
            return show_error("You must be an administrator to view this page");
	  
        $data['groups'] = $this->ion_auth->groups()->result();

        $this->load->view('groups', $data);
    }
	public function delete_permission()
    { if( ! $this->ion_auth->logged_in() )
            redirect('admin/login');


        if( ! $this->ion_auth_acl->has_permission('admin_access') )
            return show_error("You must be an administrator to view this page");
	
        if( $this->input->post() && $this->input->post('cancel') )
            redirect('admin/permissions', 'refresh');

        $permission_id  =   $this->uri->segment(3);


        if( ! $permission_id )
        {
            $this->session->set_flashdata('message', "No permission ID passed");
            redirect("admin/permissions", 'refresh');
        }

        if( $this->input->post() && $this->input->post('delete') )
        { 
            if( $this->ion_auth_acl->remove_permission($permission_id) )
            {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/permissions", 'refresh');
            }
            else
            {
                echo $this->ion_auth_acl->errors();
                redirect("admin/permissions", 'refresh');
            }
        }
        else
        {
            $data['message'] = ($this->ion_auth_acl->errors() ? $this->ion_auth_acl->errors() : $this->session->flashdata('message'));

            $this->load->view('delete_permission', $data);
        }
    }
	function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}
public function settings()
{if( ! $this->ion_auth->logged_in() )
            redirect('admin/login');


        if( ! $this->ion_auth_acl->has_permission('admin_access') )
            return show_error("You must be an administrator to view this page");
    
      
    $this->load->view('settings');
}
public function editSettings()
{if( ! $this->ion_auth->logged_in() )
            redirect('admin/login');


        if( ! $this->ion_auth_acl->has_permission('admin_access') )
            return show_error("You must be an administrator to view this page");
    
      
    $arr= $this->settings->get_settings();
    foreach($arr as $k=>$value)
    {
        $this->settings->edit_setting($k,$this->input->post($k));
    }
    redirect("admin/settings","refresh");
}
public function addSetting()
{     if( ! $this->ion_auth->logged_in() )
            redirect('admin/login');


        if( ! $this->ion_auth_acl->has_permission('admin_access') )
            return show_error("You must be an administrator to view this page");
    if($this->input->post("option_name"))
  { 
    $this->settings->add_setting($this->input->post('option_name'),$this->input->post('option_value'));
    redirect("admin/settings","refresh");
  }
      if(!$this->input->post("option_name"))
    {$this->load->view("addSetting");}

}
public function deleteSetting()
{if( ! $this->ion_auth->logged_in() )
            redirect('admin/login');


        if( ! $this->ion_auth_acl->has_permission('admin_access') )
            return show_error("You must be an administrator to view this page");
    $this->load->view("deleteSetting");
}
public function delSett($name)
{

  $this->settings->delete_setting(str_replace("%20"," ",$name));
  redirect("admin/deleteSetting","refresh");
}
}