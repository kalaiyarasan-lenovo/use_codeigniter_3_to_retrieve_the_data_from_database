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
            if ($key == 0) continue; // Skip header row

            $insertData[] = [
                'q_no'                 => $row[0],
                'English_Question'     => $row[1],
                'English_statement_1'  => $row[2],
                'English_statement_2' => $row[3],
                'English_statement_3'  => $row[4],
                'English_statement_4'  => $row[5],
                'English_statement_5'  => $row[6],
                'English_Assertion'    => $row[7],
                'English_Reason'       => $row[8],
                'English_match_left'   => $row[9],
                'English_match_right'  => $row[10],
                'Tamil_Question'       => $row[11],
                'Tamil_statement_1'    => $row[12],
                'Tamil_statement_2'    => $row[13],
                'Tamil_statement_3'    => $row[14],
                'Tamil_statement_4'    => $row[15],
                'Tamil_statement_5'    => $row[16],
                'Tamil_Assertion'      => $row[17],
                'Tamil_Reason'         => $row[18],
                'Tamil_match_left'     => $row[19],
                'Tamil_match_right'    => $row[20],
                'T_option_1'           => $row[21],
                'T_option_2'           => $row[22],
                'T_option_3'           => $row[23],
                'T_option_4'           => $row[24],
                'E_option_1'           => $row[25],
                'E_option_2'           => $row[26],
                'E_option_3'           => $row[27],
                'E_option_4'           => $row[28],
                'English_answer'       => $row[29],
                'Tamil_answer'       => $row[30],
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
