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
                'Q_no'            => $row[0],
                'Question'        => $row[1],
                'Column_A'        => $row[2],
                'Column_B'        => $row[3],
                'Option_1'        => $row[4],
                'Option_2'        => $row[5],
                'Option_3'        => $row[6],
                'Option_4'        => $row[7],
                'Correct_Answer'  => $row[8],
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
