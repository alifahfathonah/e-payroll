<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaji extends CI_Controller
{
	public function index()
	{
		$q = urldecode($this->input->get('q', TRUE));
		$start = intval($this->input->get('start'));
		if ($q <> '') {
			$config['base_url'] = base_url().'admin/index.html?q='.urlencode($q);
			$config['first_url'] = base_url().'admin/index.html?q='.urlencode($q);

		} else {
			$config['base_url'] = base_url().'admin/index.html?q=';
			$config['first_url'] = base_url().'admin/index.html?q=';
		}

		$config['per_page'] = 10;
		$config['page_query_string'] = TRUE;
		$config['total_rows'] = $this->M_gaji->total_rows($q);
		$gaji = $this->M_gaji->get_limit_data($config['per_page'], $start, $q);

		$this->load->library('pagination');
        $this->pagination->initialize($config);

		$data = array(
            'gaji_data' => $gaji,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'konten' => 'admin/listgaji',
            'judul' => 'Data Gaji Karyawan',
        );
        $this->load->view('index', $data);
	}

	public function read($id)
	{
		$row = $this->M_gaji->get_by_id($id);
        if ($row) {
            $data = array(
				'id_gaji' => $row->id_gaji,
				'tgl' => $row->tgl,
				'nik' => $row->nik,
			);
            $this->load->view('gaji/gaji_read', $data);

        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(base_url('gaji'));
        }
	}

	public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => base_url('gaji/create_action'),
			'id_gaji' => set_value('id_gaji'),
			'tgl' => set_value('tgl'),
			'nik' => set_value('nik'),
			'konten' => 'admin/formgaji',
            'judul' => 'Data Gaji Karyawan',
    	);
        $this->load->view('index', $data);
    }

	public function create_action() 
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();

        } else {
            $data = array(
				'tgl' => $this->input->post('tgl',TRUE),
				'nik' => $this->input->post('nik',TRUE),
	    	);
            $this->M_gaji->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(base_url('gaji'));
        }
    }

	public function update($id) 
    {
        $row = $this->M_gaji->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => base_url('gaji/update_action'),
				'id_gaji' => set_value('id_gaji', $row->id_gaji),
				'tgl' => set_value('tgl', $row->tgl),
				'nik' => set_value('nik', $row->nik),
				'konten' => 'admin/formgaji',
				'judul' => 'Data Gaji Karyawan',
			);
            $this->load->view('index', $data);

        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(base_url('gaji'));
        }
    }

	public function update_action() 
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_gaji', TRUE));

        } else {
            $data = array(
				'tgl' => $this->input->post('tgl',TRUE),
				'nik' => $this->input->post('nik',TRUE),
			);

            $this->M_gaji->update($this->input->post('id_gaji', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(base_url('gaji'));
        }
    }

	public function delete($id) 
    {
        $row = $this->M_gaji->get_by_id($id);
        if ($row) {
            $this->M_gaji->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(base_url('gaji'));
			
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(base_url('gaji'));
        }
    }

	public function _rules() 
    {
		$this->form_validation->set_rules('tgl', 'tgl', 'trim|required');
		$this->form_validation->set_rules('nik', 'nik', 'trim|required');
		$this->form_validation->set_rules('id_gaji', 'id_gaji', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}
