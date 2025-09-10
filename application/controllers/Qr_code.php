<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class Qr_code extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Generate QR code
    public function index() {
        $writer = new PngWriter();

        // URL that mobile hits to trigger PC
        $url = site_url('qr_code/trigger'); // Example: http://192.168.1.10/CodeIgniter_3/index.php/qr_code/trigger

        $qrCode = new QrCode(
            data: $url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: 300,
            margin: 10,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );

        $result = $writer->write($qrCode);

        header('Content-Type: '.$result->getMimeType());
        echo $result->getString();
    }

    // Endpoint mobile visits to trigger PC
    public function trigger() {
        // Set trigger = 1
        $this->db->update('qr_triggers', ['triggered' => 1], ['id' => 1]);
        echo "Triggered!";
    }

    // Endpoint PC polls to check if triggered
    public function check_trigger() {
        $row = $this->db->get_where('qr_triggers', ['id' => 1])->row();
        if($row->triggered == 1) {
            // Reset trigger
            $this->db->update('qr_triggers', ['triggered' => 0], ['id' => 1]);
            echo "1"; // triggered
        } else {
            echo "0"; // not triggered
        }
    }
}
