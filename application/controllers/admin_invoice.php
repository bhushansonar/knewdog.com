<?php

class Admin_invoice extends CI_Controller {
    /**
     * name of the folder responsible for the views 
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = 'kd2a2a0u1g4/invoice';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('invoice_model');
        $this->load->model('site_language_model');
        $this->load->model('newsletter_language_model');
        $this->load->model('newsletter_keyword_model');
        $this->load->helper('url');
        if (!$this->session->userdata('is_logged_in_admin')) {
            redirect('kd2a2a0u1g4/login');
        }
    }

    function __encrip_password($password) {
        return md5($password);
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {

        //all the posts sent by the view
        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');

        //pagination settings
        $config['per_page'] = 1;

        $config['base_url'] = base_url() . 'kd2a2a0u1g4/invoice';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //limit end
        $page = $this->uri->segment(3);

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }

        //if order type was changed
        if ($order_type) {
            $filter_session_data['order_type'] = $order_type;
        } else {
            //we have something stored in the session? 
            if ($this->session->userdata('order_type')) {
                $order_type = $this->session->userdata('order_type');
            } else {
                //if we have nothing inside session, so it's the default "Asc"
                $order_type = 'DESC';
            }
        }
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type;


        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data
        //filtered && || paginated
        
        if ($search_string !== false && $order !== false || $this->uri->segment(3) == true) {

            /*
              The comments here are the same for line 79 until 99

              if post is not null, we store it in session data array
              if is null, we use the session data already stored
              we save order into the the var to load the view with the param already selected
             */
            if ($search_string) {
                $filter_session_data['search_string_selected'] = $search_string;
            } else {
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if ($order) {
                $filter_session_data['order'] = $order;
            } else {
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            if (isset($filter_session_data)) {
                $this->session->set_userdata($filter_session_data);
            }

            //fetch sql data into arrays
            $data['count_products'] = $this->invoice_model->count_invoice($search_string, $order);
            $config['total_rows'] = $data['count_products'];
            

            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['invoice'] = $this->invoice_model->get_invoice($search_string, $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['invoice'] = $this->invoice_model->get_invoice($search_string, '', $order_type, $config['per_page'], $limit_end);
                }
            } else {
                if ($order) {
                    $data['invoice'] = $this->invoice_model->get_invoice('', $order, $order_type, $config['per_page'], $limit_end, "");
                } else {
                    $data['invoice'] = $this->invoice_model->get_invoice('', '', $order_type, $config['per_page'], $limit_end);
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['user_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_products'] = $this->invoice_model->count_invoice();
            $data['invoice'] = $this->invoice_model->get_invoice('', '', $order_type, $config['per_page'], $limit_end);
            //echo "<pre>";print_r($data['invoice']);
            $config['total_rows'] = $data['count_products'];
            //echo "<pre>";print_r($config['total_rows']);exit;
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper 
        $this->pagination->initialize($config);

        //load the view
        $data['main_content'] = 'kd2a2a0u1g4/invoice/list';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

//index

//    function invoicelist() {
//        $user_id = $this->session->userdata("user_id");
//        $field = array("user_id");
//        $value = array($user_id);
//        $get_invoice = $this->invoice_model->get_invoice_by_field($field, $value);
//        $data['invoice'] = $get_invoice;
//        $data['main_content'] = 'invoicelist_view';
//        $this->load->view('includes/template', $data);
//    }
    
function invoicepdf() {
        //$user_id = $this->session->userdata("user_id");
        $invoice_id = $this->uri->segment(4);
        //require_once("dompdf/dompdf_config.inc.php");
        $this->load->model("invoice_model");

        $field =array("invoice_id");
        $value =array($invoice_id);

        $get_invoice = $this->invoice_model->get_invoice_by_field($field, $value);
        $data['invoice'] = $get_invoice;
        //$data['main_content'] = 'invoicelist_view';
        $get_html = $this->load->view('mail_templates/invoice_template.php', $data, true);
        echo $get_html;
        /* $dompdf = new DOMPDF();
          $dompdf->set_base_path(site_url('assets/css/invoice_pdf.css'));
          $dompdf->load_html($get_html);
          $dompdf->set_paper("8.5x11", "portrait");
          $dompdf->render();
          // The next call will store the entire PDF as a string in $pdf
          $pdf = $dompdf->output();
          $dompdf->stream('invoice'.$get_invoice[0]["item_number"].'.pdf',array('Attachment'=>0)); */
        // You can now write $pdf to disk, store it in a database or stream it
        // to the client.
        //$dompdf->stream("infopdf.pdf");
        //$pdfname = "infopdf_".rand().".pdf";
        //$filename="images/pdffiles/".$pdfname;
        //file_put_contents($filename, $pdf);
    }
}