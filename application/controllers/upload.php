<?php
class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'html', 'url'));
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
			$upload_data = $this->upload->data();
			if ($this->_unzip($upload_data['full_path'], "uploads/{$upload_data['raw_name']}") === TRUE)
			{
				unlink($upload_data['full_path']);
				$this->_analyze($upload_data);
				$data = $this->_read_csv('results/' . $upload_data['raw_name'] . '.csv');
				$this->load->view('upload_success', array('data' => $data));
			}
			else
				show_error('Failed to unzip file.');
		}
	}
	
	private function _analyze($upload_data)
	{
			exec("(cd application/third_party/yasca && yasca --silent --report CSVReport --output ../../../results/{$upload_data['raw_name']} ../../../uploads/{$upload_data['raw_name']})");
	}
	
	private function _read_csv($file_path)
	{
		if (($handle = fopen($file_path, "r")) !== FALSE)
		{
			$data = array();
			while (($fields = fgetcsv($handle, 1000, ",", "`")) !== FALSE)
				$data[] = $fields;
			fclose($handle);
			return $data;
		}
	}

	private function _unzip($file_path, $destination)
	{
		$zip = new ZipArchive();
		if ($zip->open($file_path) === TRUE) {
			$zip->extractTo($destination);
			$zip->close();
			return TRUE;
		}
		else
			return FALSE;
	}
}
?>