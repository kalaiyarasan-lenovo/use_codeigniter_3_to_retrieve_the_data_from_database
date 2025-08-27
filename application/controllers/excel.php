<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Excel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        $this->load->database();
        $this->load->model('Excel_model');

        // PhpSpreadsheet
        require 'vendor/autoload.php';
    }

    // Show form
    public function index() {
        $this->load->view('upload_form');
    }

    // Import Excel file
    public function import() {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size']      = 4096;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('excel_file')) {
            echo $this->upload->display_errors();
            return;
        }

        $fileData = $this->upload->data();
        $filePath = $fileData['full_path'];

        $reader = new Xlsx();
        $spreadsheet = $reader->load($filePath);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $insertData = [];

        foreach ($sheetData as $key => $row) {
            if ($key == 0) continue; // Skip header

            $insertData[] = [
                'q_no'                 => $row[0],
                'English_Question'     => $row[1],
                'English_statement_1'  => $row[2],
                'English_statements_2' => $row[3],
                'English_Assertion'    => $row[4],
                'English_Reason'       => $row[5],
                'English_match_left'   => $row[6],
                'English_match_right'  => $row[7],
                'English_options'      => $row[8],
                'Tamil_Question'       => $row[9],
                'Tamil_statement_1'    => $row[10],
                'Tamil_statement_2'    => $row[11],
                'Tamil_Assertion'      => $row[12],
                'Tamil_Reason'         => $row[13],
                'Tamil_match_left'     => $row[14],
                'Tamil_match_right'    => $row[15],
                'Tamil_options'        => $row[16],
            ];
        }

        if (!empty($insertData)) {
            $this->Excel_model->insert_batch($insertData);
            echo "Excel file imported successfully!";
        } else {
            echo "No data found in Excel file.";
        }
    }

    // Optional: Display inserted data
    public function show_data() {
        $data['records'] = $this->Excel_model->get_all();
        $this->load->view('show_data', $data);
    }
}
