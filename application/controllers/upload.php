<?php
class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	function index()
	{
		$this->load->view('upload_form', array('error' => ' ' ));
	}

	function do_upload()
	{
		$config['upload_path'] = 'uploads';
		$config['allowed_types'] = 'zip';
		$config['max_size']	= '10,240';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			// $this->load->view('upload_success', $data);
			$this->_analyze($data['upload_data']);
		}
	}
	
	private function _analyze($upload_data)
	{
		echo "application/third_party/yasca/yasca.exe --silent --report CSVReport --output {$upload_data['raw_name']} {$upload_data['full_path']}";
		// exec("application/third_party/yasca/yasca.exe --silent --report CSVReport --output {$upload_data['raw_name']} {$upload_data['full_path']}");
	}
}
?>