<?php

/**
 * Description of administracion1
 *
 * @author desarrollo
 */
class Usuarios extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('general_model');
		$this->load->model('usuario_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
	}

	public function index()
	{
		if($this->session->userdata('logged') != TRUE){
			redirect(base_url().'login');
		}
		$data["grupo_usuario"] = $this->general_model->get('grupos_usuarios');
		$data["status_usuario"] = $this->general_model->get('status_usuarios');
		$data["sede"] = $this->general_model->get('sedes');
		$data["lista"] = $this->usuario_model->get();
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('administrar/usuarios',$data);
		$this->load->view('template/footer');
	}
		
	public function get($cedula=FALSE)
	{
		if($this->session->userdata('logged') != TRUE){
			redirect(base_url().'login');
		}
		echo json_encode($this->usuario_model->get($cedula));
	}
	
	
	public function eliminar($cedula)
	{
		if($this->session->userdata('logged') != TRUE){
			redirect(base_url().'login');
		}
		echo $this->usuario_model->eliminar($cedula);
	}
	
	public function agregar()
	{
		if($this->session->userdata('logged') != TRUE){
			redirect(base_url().'login');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('cedula', 'Cedula', 'trim|required|max_length[10]');
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[60]');
		$this->form_validation->set_rules('apellido', 'Apellido', 'trim|required|max_length[60]');
		$this->form_validation->set_rules('telefono', 'Telefono', 'trim|required|max_length[12]');
		$this->form_validation->set_rules('correo', 'Correo', 'trim|required|max_length[150]|valid_email');
		$this->form_validation->set_rules('grupo_usuario', 'Grupo Usuario', 'trim|required|integer');
		$this->form_validation->set_rules('status_usuario', 'Status Usuario', 'trim|required|integer');
		$this->form_validation->set_rules('sede', 'Sede', 'trim|required|integer');
		if($this->form_validation->run())
		{
			$cedula = $this->input->post('cedula');
			$nombre = $this->input->post('nombre');
			$apellido = $this->input->post('apellido');
			$telefono = $this->input->post('telefono');
			$correo = $this->input->post('correo');
			$grupo = $this->input->post('grupo_usuario');
			$status = $this->input->post('status_usuario');
			$sede = $this->input->post('sede');
			echo $this->usuario_model->agregar($cedula,$nombre,$apellido,$telefono,$correo,$grupo,$status,$sede);
		}
		else
			echo '-1';
	}
	
	public function editar()
	{
		if($this->session->userdata('logged') != TRUE){
			redirect(base_url().'login');
		}
		$this->form_validation->set_rules('cedula', 'Cedula', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|max_length[60]');
		$this->form_validation->set_rules('apellido', 'Apellido', 'trim|required|max_length[60]');
		$this->form_validation->set_rules('telefono', 'Telefono', 'trim|required|max_length[12]');
		$this->form_validation->set_rules('correo', 'Correo', 'trim|required|max_length[150]|valid_email');
		$this->form_validation->set_rules('grupo_usuario', 'Grupo Usuario', 'trim|required|integer');
		$this->form_validation->set_rules('status_usuario', 'Status Usuario', 'trim|required|integer');
		$this->form_validation->set_rules('sede', 'Sede', 'trim|required|integer');
		if($this->form_validation->run())
		{
			$cedula = $this->input->post('cedula');
			$nombre = $this->input->post('nombre');
			$apellido = $this->input->post('apellido');
			$telefono = $this->input->post('telefono');
			$correo = $this->input->post('correo');
			$grupo = $this->input->post('grupo_usuario');
			$status = $this->input->post('status_usuario');
			$sede = $this->input->post('sede');
			echo $this->usuario_model->editar($cedula,$nombre,$apellido,$telefono,$correo,$grupo,$status,$sede);
		}
		else
			echo '-1';
	}

	public function resetear_clave($cedula=FALSE)
	{
		if($this->session->userdata('logged') != TRUE){
			redirect(base_url().'login');
		}
		echo json_encode($this->usuario_model->restaurar_clave($cedula));
	}
	
	public function cambiar_clave()
	{
		if($this->session->userdata('logged') != TRUE){
			redirect(base_url().'login');
		}
		$cedula= $this->session->userdata('cedula');
		$new_clave=$this->input->post('pass_nuevo');
		echo $this->usuario_model->editar_clave($cedula, $new_clave);
	}
	
	public function iniciar_session(){
		$cedula = $this->input->post('cedula');
		$clave = $this->input->post('clave');
		$userdata = $this->usuario_model->verificar_clave($cedula,$clave);
		if($userdata == false){
			echo 0;
		}
//		if($userdata->status_usuario == 2){
//			echo -1;
//		}
		else{
			
			$newdata = array(
				'cedula' => $userdata->cedula,
				'nombre'=> $userdata->nombre,
				'apellido'=> $userdata->apellido,
				'grupo_usuario'=> $userdata->grupo_usuario,
				'sede'=> $userdata->sede,
				'logged' => TRUE
				);
				$this->session->set_userdata($newdata);
				echo 1;
		}
	}
	
	public function cerrar_session(){
		$this->session->sess_destroy();
		redirect(base_url().'login');
	}

	public function login(){
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('login');
		$this->load->view('template/footer');
	}
	
	public function cambiar_password(){
		if($this->session->userdata('logged') != TRUE){
			redirect(base_url().'login');
		}
		$this->load->view('template/header');
		$this->load->view('template/menu');
		$this->load->view('template/password');
		$this->load->view('template/footer');
	}

}

?>
