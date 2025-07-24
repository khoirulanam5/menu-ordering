<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;
use Dompdf\Options;
class Pdf extends Dompdf{
    public $filename;  
    public function __construct(){
        parent::__construct();
               $this->filename = "laporan.pdf";
    }
    public function cek()
    {
        echo "lib ok";
    }
    protected function ci()
    {
        return get_instance();
    }
    public function createpdf($view, $data = array()){
        $options = new Options();
        $options->setChroot(FCPATH); 
        $options = $this->getOptions(); 
        $options->set(array('isRemoteEnabled' => true));
        $this->setOptions($options);
        $html = $this->ci()->load->view($view, $data, TRUE);
        $this->load_html($html);
        $this->render();
        $pdf_string =   $this->output();
        file_put_contents("pdf/".$this->filename, $pdf_string ); 
    }
    public function previewpdf($view, $data = array()){
        $options = new Options();
        $options->setChroot(FCPATH); 
        $options = $this->getOptions(); 
        $options->set(array('isRemoteEnabled' => true));
        $this->setOptions($options);
        $html = $this->ci()->load->view($view, $data, TRUE);
        $this->load_html($html);
        $this->render();
        $this->stream($this->filename, array("Attachment" => false));
    }
}
?>