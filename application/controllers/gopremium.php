<?php

class Gopremium extends CI_Controller {
    /**
     * name of the folder responsible for the views 
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = 'gopremium';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('invoice_model');
//        if (!$this->session->userdata('is_logged_in')) {
//            $this->session->set_flashdata('flash_message', '<strong>' . _clang(YOU_ARE_NOW_LOGGED_OUT) . '</strong>');
//            $this->session->set_flashdata('flash_class', 'alert-error');
//            redirect('home');
//        }
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {
//echo "hii";exit;
        //all the posts sent by the view
        $user_id = $this->session->userdata('user_id');

        $data['main_content'] = 'gopremium_view';
        $this->load->view('includes/template', $data);
    }

    public function checkout() {

        //all the posts sent by the view
        $user_id = $this->session->userdata('user_id');

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //form validation
            //$this->form_validation->set_rules('keyword_name', 'keyword name', 'required|edit_unique[newsletter_keyword.keyword_name.'.$id.']');
            //echo $this->input->post('payment'); die;
            $this->form_validation->set_rules('payment', 'Membership plan', 'required');

            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if (!$this->form_validation->run()) {

                /* $data_to_store = array(
                  'keyword_name' => $this->input->post('keyword_name'),
                  'status' => $this->input->post('status'),
                  ); */
                //if the insert has returned true then we show the flash message

                /* $array = array();
                  $array = $_POST;
                  foreach($array as $k=>$v){
                  if (in_array($k,array('old_password','password2','Submit')))
                  {unset($array[$k]);}
                  if(is_array($v)){
                  $array[$k] = implode(",",$v);
                  }
                  if ($k == 'password'){
                  $array[$k] = md5($v);
                  }

                  } */
                //print_r($array); die;
                /* if(@$this->user_model->update_user($id, $array) == TRUE){
                  $this->session->set_flashdata('flash_message', 'Account Settings Updated with success!');
                  $this->session->set_flashdata('flash_class', 'alert-success');
                  $this->session->set_flashdata('flash_mynl_tab', 'tab_4');
                  }else{
                  $this->session->set_flashdata('flash_message', 'opps! Something went wrong!');
                  $this->session->set_flashdata('flash_class', 'alert-error');
                  $this->session->set_flashdata('flash_mynl_tab', 'tab_4');
                  } */
                //redirect('myknewdog');
                //redirect('kd2a2a0u1g4/keyword/update/'.$id.'');

                $data['main_content'] = 'gopremium_view';
                $this->load->view('includes/template', $data);
            }
        } else {
            $data['main_content'] = 'gopremium_view';
            $this->load->view('includes/template', $data);
        }
        $data['countries'] = $this->user_model->get_countries('country_name', 'ASC');
        $data['payment'] = $this->input->post('payment');
        $data['main_content'] = 'checkout_view';
        $this->load->view('includes/template', $data);
    }

    public function paypal() {
        date_default_timezone_set('UTC');
        //all the posts sent by the view
        $user_id = $this->session->userdata('user_id');

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //form validation
            //$this->form_validation->set_rules('keyword_name', 'keyword name', 'required|edit_unique[newsletter_keyword.keyword_name.'.$id.']');
            //echo $this->input->post('payment'); die;
            $this->form_validation->set_rules('first_name', 'First name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('zip', 'Postal code', 'trim|required|numeric');
            $this->form_validation->set_rules('address1', 'Address 1', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if (!$this->form_validation->run()) {
                $data['countries'] = $this->user_model->get_countries('country_name', 'ASC');
                $data['payment'] = $this->input->post('payment_type');
                $data['main_content'] = 'checkout_view';
                $this->load->view('includes/template', $data);
            } else {
                //echo '<pre>'; print_r($_POST); die;
                $user_id = $user_id;
                $business = $this->input->post('business');
                $cmd = $this->input->post('cmd');
                $of = "on knewdog.com";
                $item_name = $this->input->post('item_name') . " " . $of;
                //$item_name = $this->input->post('item_name');
                $item_number = $this->input->post('item_number');
                $quantity = $this->input->post('quantity');
                $amount = $this->input->post('amount');
                $no_shipping = $this->input->post('no_shipping');
                $currency_code = $this->input->post('currency_code');
                $handling = $this->input->post('handling');
                $cancel_return = $this->input->post('cancel_return');
                $return = $this->input->post('return');
                $rm = $this->input->post('rm');
                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $country = $this->input->post('country');
                $city = $this->input->post('city');
                $zip = $this->input->post('zip');
                $address1 = $this->input->post('address1');
                $address2 = $this->input->post('address2');
                $email = $this->input->post('email');
                $date_from = $this->input->post('date_from');
                $date_to = $this->input->post('date_to');
                $page_style = 'knewdog_pay';

                $payment_type = $this->input->post('payment_type');

                $data_to_store = array(
                    "user_id" => $user_id,
                    "item_name" => $item_name,
                    "item_number" => $item_number,
                    "quantity" => $quantity,
                    "amount" => $amount,
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "country" => $country,
                    "city" => $city,
                    "zip" => $zip,
                    "address1" => $address1,
                    "address2" => $address2,
                    "email" => $email,
                    "payment_type" => $payment_type,
                    "payment_date" => date('Y-m-d'),
                    "date_from" => date('Y-m-d', strtotime($date_from)),
                    "date_to" => date('Y-m-d', strtotime($date_to)),
                    "status" => "pending",
                );

                //echo "<pre>"; print_r($data_to_store);exit;
                if ($this->invoice_model->store_invoice($data_to_store)) {
                    ?>
                    <script>
                    <?php /* ?>window.location.href = 'https://www.sandbox.paypal.com/cgi-bin/webscr?business=<?php echo $business?>&cmd=<?php echo $cmd?>&item_name=<?php echo $item_name?>&item_number=<?php echo $item_number;?>&quantity=<?php echo $quantity?>&amount=<?php echo $amount?>&no_shipping=<?php echo $no_shipping?>&currency_code=<?php echo $currency_code?>&handling=<?php echo $handling?>&rm=<?php echo $rm?>&cance_return=<?php echo $cancel_return?>&return=<?php echo $return?>&first_name=<?php echo $first_name?>&last_name=<?php echo $last_name?>&address1=<?php echo $address1?>&address2=<?php echo $address2?>&country=<?php echo $country?>&city=<?php echo $city?>&zip=<?php echo $zip?>&email=<?php echo $email;?>&notify_url=<?php echo site_url("premium-account/notify")?>&address_override=1';<?php */ ?>
                        //window.location.href = 'https://www.sandbox.paypal.com/cgi-bin/webscr?business=<?php echo $business ?>&cmd=<?php echo $cmd ?>&item_name=<?php echo $item_name ?>&item_number=<?php echo $item_number; ?>&quantity=<?php echo $quantity ?>&amount=<?php echo $amount ?>&no_shipping=<?php echo $no_shipping ?>&currency_code=<?php echo $currency_code ?>&handling=<?php echo $handling ?>&rm=<?php echo $rm ?>&cance_return=<?php echo $cancel_return ?>&return=<?php echo $return ?>&first_name=<?php echo $first_name ?>&last_name=<?php echo $last_name ?>&address1=<?php echo $address1 ?>&address2=<?php echo $address2 ?>&country=<?php echo $country ?>&city=<?php echo $city ?>&zip=<?php echo $zip ?>&email=<?php echo $email; ?>&notify_url=<?php echo site_url("premium-account/notify") ?>&address_override=1'&page_style=<?php echo $page_style ?>;
                        window.location.href = 'https://www.paypal.com/cgi-bin/webscr?business=<?php echo $business ?>&cmd=<?php echo $cmd ?>&item_name=<?php echo $item_name ?>&item_number=<?php echo $item_number; ?>&quantity=<?php echo $quantity ?>&amount=<?php echo $amount ?>&no_shipping=<?php echo $no_shipping ?>&currency_code=<?php echo $currency_code ?>&handling=<?php echo $handling ?>&rm=<?php echo $rm ?>&cance_return=<?php echo $cancel_return ?>&return=<?php echo $return ?>&first_name=<?php echo $first_name ?>&last_name=<?php echo $last_name ?>&address1=<?php echo $address1 ?>&address2=<?php echo $address2 ?>&country=<?php echo $country ?>&city=<?php echo $city ?>&zip=<?php echo $zip ?>&email=<?php echo $email; ?>&notify_url=<?php echo site_url("premium-account/notify") ?>&address_override=1&page_style=<?php echo $page_style ?>';
                    </script>

                    <?php
                }
            }
        } else {
            $data['main_content'] = 'gopremium_view';
            $this->load->view('includes/template', $data);
        }
        /* $data['countries'] = $this->user_model->get_countries('country_name','ASC');
          $data['payment'] = $this->input->post('payment');
          $data['main_content'] = 'checkout_view';
          $this->load->view('includes/template', $data); */
    }

    //ALTER TABLE `invoice` ADD `invoice_number` VARCHAR( 255 ) NOT NULL AFTER `user_id` ;
    

    public function notify() {

        // Check to see there are posted variables coming into the script
        if ($_SERVER['REQUEST_METHOD'] != "POST")
            die("No Post Variables");
// Initialize the $req variable and add CMD key value pair
//echo '<pre>'; print_r($_POST);
        $req = 'cmd=_notify-validate';
// Read the post from PayPal
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }
// Now Post all of that back to PayPal's server using curl, and validate everything with PayPal
// We will use CURL instead of PHP for this for a more universally operable script (fsockopen has issues on some environments)
//$url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
        $url = "https://www.paypal.com/cgi-bin/webscr";
        $curl_result = $curl_err = '';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $curl_result = @curl_exec($ch);
        $curl_err = curl_error($ch);
        curl_close($ch);

        $req = str_replace("&", "\n", $req);  // Make it a nice list in case we want to email it to ourselves for reporting
// Check that the result verifies
        if (strpos($curl_result, "VERIFIED") !== false) {
            $req .= "\n\nPaypal Verified OK";
        } else {
            $req .= "\n\nData NOT verified from Paypal!";
            mail("you@youremail.com", "IPN interaction not verified", "$req", "From: you@youremail.com");
            exit();
        }

        /* CHECK THESE 4 THINGS BEFORE PROCESSING THE TRANSACTION, HANDLE THEM AS YOU WISH
          1. Make sure that business email returned is your business email
          2. Make sure that the transaction�s payment status is �completed�
          3. Make sure there are no duplicate txn_id
          4. Make sure the payment amount matches what you charge for items. (Defeat Price-Jacking) */

// Check Number 1 ------------------------------------------------------------------------------------------------------------
        $receiver_email = $_POST['receiver_email'];
        if ($receiver_email != "you@youremail.com") {
//handle the wrong business url
            exit(); // exit script
        }
// Check number 2 ------------------------------------------------------------------------------------------------------------
        if ($_POST['payment_status'] != "Completed") {
            // Handle how you think you should if a payment is not complete yet, a few scenarios can cause a transaction to be incomplete
        }

// Check number 3 ------------------------------------------------------------------------------------------------------------
        $this_txn = $_POST['txn_id'];
//check for duplicate txn_ids in the database
// Check number 4 ------------------------------------------------------------------------------------------------------------
        $product_id_string = $_POST['custom'];
        $product_id_string = rtrim($product_id_string, ","); // remove last comma
// Explode the string, make it an array, then query all the prices out, add them up, and make sure they match the payment_gross amount
// END ALL SECURITY CHECKS NOW IN THE DATABASE IT GOES ------------------------------------
////////////////////////////////////////////////////
// Homework - Examples of assigning local variables from the POST variables
        $txn_id = $_POST['txn_id'];
        $payer_email = $_POST['payer_email'];
        $custom = $_POST['custom'];
// Place the transaction into the database
// Mail yourself the details
        mail("you@youremail.com", "NORMAL IPN RESULT YAY MONEY!", $req, "From: you@youremail.com");
    }

    function do_upload($filename) {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2048';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($filename)) {
            $response = array('error' => $this->upload->display_errors());
            //$this->load->view('upload_form', $error);
        } else {
            $response = array('upload_data' => $this->upload->data());
            //$this->load->view('upload_success', $data);
        }

        return $response;
    }

    function validate_category($str) {
        $array_value = $str; //this is redundant, but it's to show you how
        //the content of the fields gets automatically passed to the method
        //print_r($str);
        if (count($array_value) <= 3) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function validate_keyword($str) {
        $array_value = $str; //this is redundant, but it's to show you how
        //the content of the fields gets automatically passed to the method
        //print_r($str);
        if (count($array_value) <= 20) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}