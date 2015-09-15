<div class="container top"> 
    <ul class="breadcrumb">      
        <li>     
            <a href="<?php echo site_url("kd2a2a0u1g4/dashboard"); ?>">     
                <?php echo ucfirst($this->uri->segment(1)); ?></a> 
            <span class="divider">/</span>  
        </li>    
        <li class="active">          
            <?php echo ucfirst($this->uri->segment(2)); ?>     
        </li>   
    </ul>   
    <div class="page-header users-header"> 
        <h2>       
            <?php echo ucfirst($this->uri->segment(2)); ?>      
            <a  href="<?php echo site_url("kd2a2a0u1g4") . '/' . $this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>   
            <a style="margin-right:30px;" href="<?php echo site_url("kd2a2a0u1g4") . '/' . $this->uri->segment(2); ?>/exportcsv" class="btn btn-info">Export User</a>     
        </h2>   
    </div>    <?php //\\print_r($this->session->userdata('flash_message'));    //print_r($this->session->flashdata('data'));    //flash messages    echo validation_errors();    //echo $this->session->flashdata('flash_message');    if ($this->session->flashdata('flash_message')) {        if ($this->session->flashdata('flash_message') == 'add') {            echo '<div class="alert alert-success">';            echo '<a class="close" data-dismiss="alert">&#215;</a>';            echo '<strong>Well done!</strong> new user created with success.';            echo '</div>';        } else if ($this->session->flashdata('flash_message') == 'update') {            echo '<div class="alert alert-success">';            echo '<a class="close" data-dismiss="alert">&#215;</a>';            echo '<strong>Well done!</strong> user updated with success.';            echo '</div>';        } else if ($this->session->flashdata('flash_message') == 'delete') {            echo '<div class="alert alert-success">';            echo '<a class="close" data-dismiss="alert">&#215;</a>';            echo '<strong>Well done!</strong> user deleted with success.';            echo '</div>';        } else {            echo '<div class="alert alert-error">';            echo '<a class="close" data-dismiss="alert">&#215;</a>';            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';            echo '</div>';        }    }    //echo "permission->".user_access($this->session->userdata('user_id'),'delete_users');                   ?>    <div class="row">        <div class="span12 columns">            <div class="well">    <?php
                $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
                $options_keyword = array();
                foreach ($user as $array) {
                    foreach ($array as $key => $value) {
                        $options_keyword[$key] = $key;
                    }
                } echo form_open('kd2a2a0u1g4/user', $attributes);
                echo form_label('Search:', 'search_string');
                echo form_input('search_string', $search_string_selected);
                ?>                <select name="order" class="span2">       
                    <option <?php echo ($order == 'user.user_id') ? 'selected="selected"' : "" ?> value="user.user_id">User Id</option> 
                    <option <?php echo ($order == 'firstname') ? 'selected="selected"' : "" ?> value="firstname">Firstname</option> 
                    <option <?php echo ($order == 'lastname') ? 'selected="selected"' : "" ?> value="lastname">Lastname</option>  
                    <option <?php echo ($order == 'username') ? 'selected="selected"' : "" ?> value="username">Username</option>
                    <option <?php echo ($order == 'primary_email') ? 'selected="selected"' : "" ?> value="primary_email">User Email</option>  
                    <option <?php echo ($order == 'language_interface') ? 'selected="selected"' : "" ?> value="language_interface">Language Interface</option>  
                    <option <?php echo ($order == 'type_of_membership') ? 'selected="selected"' : "" ?> value="type_of_membership">Type of membership</option>  
                    <option <?php echo ($order == 'status') ? 'selected="selected"' : "" ?> value="status">Status</option>          
                </select>
                <?php
                echo form_label('Order by:', 'order');
                //echo form_dropdown('order', $options_keyword, $order, 'class="span2"');
                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');
                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');
                echo form_submit($data_submit);
                if ($search_string_selected) {
                    echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="' . site_url("kd2a2a0u1g4/user/") . '">Reset</a>';
                }
                echo form_close();
                ?>           
            </div>          
            <table class="table table-striped table-bordered table-condensed">           
                <thead>                    <tr>                      
                        <th class="header">#</th>                        
                        <th class="yellow header headerSortDown">Firstname</th>                 
                        <th class="yellow header headerSortDown">Lastname</th>             
                        <th class="yellow header headerSortDown">Username</th>
                         <th class="yellow header headerSortDown">User Email</th>  
                        <th class="yellow header headerSortDown">Language Interface</th>       
                        <th class="yellow header headerSortDown">Type of membership</th> 
                        <th class="yellow header headerSortDown">From date</th>
                        <th class="yellow header headerSortDown">To date</th>
                        <th class="yellow header headerSortDown">Status</th>
                        <th class="yellow header headerSortDown" style="text-align: center;">Action</th>
                    </tr>              
                </thead>       
                <tbody><?php
                    $this->load->model('site_language_model');
//                    echo "<pre>";
//                    print_r($user);
//                    exit;

                    foreach ($user as $row) {
                        echo '<tr>';
                        echo '<td>' . $row['user_id'] . '</td>';
                        echo '<td>' . $row['firstname'] . '</td>';
                        echo '<td>' . $row['lastname'] . '</td>';
                        echo '<td>' . $row['username'] . '</td>';
                        echo '<td>' . $row['primary_email'] . '</td>';
                        $language_interface = $this->site_language_model->get_language_by_id($row['language_interface']);
                        $lang = !empty($language_interface[0]['language_longform']) ? $language_interface[0]['language_longform'] : '--';
                        echo '<td>' . $lang . '</td>';
                        echo '<td>' . $row['type_of_membership'] . '</td>';
                        if ($row['type_of_membership'] == "FREE") {
                            $date_from = "";
                            $date_to = "";
                        } else {
                            $date_from = $row['date_from'];
                            $date_to = $row['date_to'];
                        }
                        echo '<td>' . $date_from . '</td>';
                        echo '<td>' . $date_to . '</td>';
                        echo '<td>' . $row['status'] . '</td>';
                        echo '<td style="text-align:center;" class="crud-actions">';
                        echo '<a  href="' . site_url("kd2a2a0u1g4") . '/user/update/' . $row['user_id'] . '" class="btn btn-info">view & edit</a>  		  
                        </td>';
                        echo '</tr>';
                    }/* <a href="'.site_url("kd2a2a0u1g4").'/user/delete/'.$row['user_id'].'" class="btn btn-danger complexConfirm">delete</a> */
                    ?>                      </tbody>  
            </table>                    <?php
            $this->session->set_userdata('redirect_url', current_url());
            echo '<div class="pagination">' . $this->pagination->create_links() . '</div>';
            ?>     
        </div>  
    </div>