<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kode_akuntansi_c extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('kode_akuntansi_m','model');
		$data = $this->session->userdata('sign_in');
        $nama = $data['id'];

        if($nama == "" || $nama == null){
        	redirect('login_c','refresh');
        }
	}

	public function index()
	{
		$data = array(
				'title' 	 		=> 'Master Kode Akuntansi',
				'page'  	 		=> 'kode_akuntansi_v',
				'sub_menu' 	 		=> 'master data',
				'sub_menu1'	 		=> 'master kode akuntansi',
				'menu' 	   	 		=> 'master_data',
				'menu2'		 		=> 'kode_akuntansi',
				'lihat_data' 		=> $this->model->lihat_data_kode_akun(),
				'url_simpan' 		=> base_url().'kode_akuntansi_c/simpan',
				'url_hapus'  		=> base_url().'kode_akuntansi_c/hapus',
				'url_ubah'	 		=> base_url().'kode_akuntansi_c/ubah_kode_akun',
			);
		
		$this->load->view('home_v',$data);
	}

	function simpan()
	{
		$kode_akun   = $this->input->post('kode_akun');
		$nama_akun 	 = $this->input->post('nama_akun');
		$tipe 		 = $this->input->post('tipe');
		$kategori 	 = $this->input->post('kategori');
		$deskripsi 	 = $this->input->post('deskripsi');
		$level 		 = $this->input->post('level');
		$anak_dari 	 = $this->input->post('anak_dari');
		$id_klien 	 = $this->input->post('id_klien');
		$approve 	 = $this->input->post('approve');
		$user_input  = $this->input->post('user_input');
		$tgl_input 	 = $this->input->post('tgl_input');
		$kode_grup 	 = $this->input->post('kode_grup');
		$kode_sub 	 = $this->input->post('kode_sub');
		$unit 		 = $this->input->post('unit');

		$this->model->simpan_data_kode_akun($kode_akun,$nama_akun,$tipe,$kategori,$deskripsi,$level,$anak_dari,
											$id_klien,$approve,$user_input,$tgl_input,$kode_grup,$kode_sub,$unit);
		$this->session->set_flashdata('sukses','1');
		redirect('kode_akuntansi_c');
	}

	function hapus()
	{
		$id = $this->input->post('id_hapus');
		$this->model->hapus_kode_akun($id);
		$this->session->set_flashdata('hapus','1');
		redirect('kode_akuntansi_c');
	}

	function data_kode_akun_id()
	{
		$id = $this->input->post('id');
		$data = $this->model->data_kode_akun_id($id);
		echo json_encode($data);
	}

	function ubah_kode_akun()
	{
		$id 				= $this->input->post('id_akun_modal');
		$kode_akun_modal  	= $this->input->post('kode_akun_modal');
		$nama_akun_modal 	= $this->input->post('nama_akun_modal');
		$tipe_modal  		= $this->input->post('tipe_modal');
		$kategori_modal  	= $this->input->post('kategori_modal');
		$deskripsi_modal  	= $this->input->post('deskripsi_modal');
		$level_modal  		= $this->input->post('level_modal');
		$anak_dari_modal  	= $this->input->post('anak_dari_modal');
		$id_klien_modal  	= $this->input->post('id_klien_modal');
		$approve_modal  	= $this->input->post('approve_modal');
		$user_input_modal  	= $this->input->post('user_input_modal');
		$tgl_input_modal  	= $this->input->post('tgl_input_modal');
		$kode_grup_modal  	= $this->input->post('kode_grup_modal');
		$kode_sub_modal  	= $this->input->post('kode_sub_modal');
		$unit_modal  		= $this->input->post('unit_modal');
		
		$this->model->ubah_kode_akun($id,$kode_akun_modal,$nama_akun_modal,$tipe_modal,$kategori_modal,$deskripsi_modal,$level_modal,$anak_dari_modal,
									  $id_klien_modal,$approve_modal,$user_input_modal,$tgl_input_modal,$kode_grup_modal,$kode_sub_modal,$unit_modal);
		$this->session->set_flashdata('sukses','1');
		redirect('kode_akuntansi_c');	
		// echo "1";
	}

	public function get_data_depart()
	{
		$kode =$this->input->post('kode');
		$sql  ="select * from master_departemen where id_depart = $kode ";
		$data = $this->db->query($sql)->row();

		echo json_encode($data); 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */