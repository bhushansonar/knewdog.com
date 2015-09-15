<div class="container top">        <ul class="breadcrumb">   
        <li> <a href="<?php echo site_url("kd2a2a0u1g4/dashboard"); ?>"> 
                <?php echo ucfirst($this->uri->segment(1)); ?>  
            </a>                        <span class="divider">/</span>
        </li>                <li class="active">          
            <?php echo ucfirst($this->uri->segment(2)); ?>      
        </li>        </ul>      <div class="page-header users-header">     
        <h2>            <?php echo ucfirst($this->uri->segment(2)); ?>     
<!--                <a  href="<?php echo site_url("kd2a2a0u1g4") . '/' . $this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>      -->
        </h2>      
    </div>  <div class="row">   
        <div class="span12 columns">               
            <div class="well">    
                <?php
                $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
                $options_keyword = array();
                foreach ($invoice as $array) {
                    foreach ($array as $key => $value) {
                        $options_keyword[$key] = $key;
                    } break;
                } echo form_open('kd2a2a0u1g4/invoice', $attributes);
                echo form_label('Search:', 'search_string');
                echo form_input('search_string', $search_string_selected);
                ?>                               <select name="order" class="span2">   
                    <option <?php echo ($order == 'user.user_id') ? 'selected="selected"' : "" ?> value="user.user_id">User Id</option> 
                    <option <?php echo ($order == 'user.username') ? 'selected="selected"' : "" ?> value="user.username">Username</option>         
                    <option <?php echo ($order == 'user.primary_email') ? 'selected="selected"' : "" ?> value="user.primary_email">User Email</option>           
                    <option <?php echo ($order == 'invoice.item_number') ? 'selected="selected"' : "" ?> value="invoice.item_number">Invoice Number</option>      
                    <option <?php echo ($order == 'invoice.item_name') ? 'selected="selected"' : "" ?> value="invoice.item_name">Item name</option>       
                    <option <?php echo ($order == 'invoice.status') ? 'selected="selected"' : "" ?> value="invoice.status">Status</option>               
                </select>              
                <?php
                echo form_label('Order by:', 'order');
                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');
                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');
                echo form_submit($data_submit);
                if ($search_string_selected) {
                    echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="' . site_url("kd2a2a0u1g4/invoice") . '">Reset</a>';
                } echo form_close();
                ?>        
            </div>    
            <table class="table table-striped table-bordered table-condensed">   
                <thead>         
                    <tr>       
                        <th class="header">#</th>     
                        <th class="yellow header headerSortDown">User id</th>  
                        <th class="yellow header headerSortDown">User Name</th>    
                        <th class="yellow header headerSortDown">User Email</th>   
                        <th class="yellow header headerSortDown">Invoice Number</th> 
                        <th class="yellow header headerSortDown">Item name</th>    
                        <th class="yellow header headerSortDown">Quantity</th>     
                        <th class="yellow header headerSortDown">Amount</th>       
                        <th class="yellow header headerSortDown">From Date</th>    
                        <th class="yellow header headerSortDown">To Date</th>     
                        <th class="yellow header headerSortDown">Payment Status</th>    
                        <th class="yellow header headerSortDown" style="text-align:center;">Action</th>         
                    </tr>          
                </thead>          
                <tbody>      
                    <?php
                    foreach ($invoice as $key => $row) {

                        if ($row['status'] == "pending") {
                            $payment_status = "failed";
                            $class = 'style="color:red"';
                        } else {
                            $payment_status = $row['status'];
                            $class = 'style="color:black"';
                        }

                        echo '<tr>';
                        echo '<td>' . $key . '</td>';
                        echo '<td>' . $row['user_id'] . '</td>';
                        echo '<td>' . $row['username'] . '</td>';
                        echo '<td>' . $row['primary_email'] . '</td>';
                        echo '<td>' . $row['item_number'] . '</td>';
                        echo '<td>' . $row['item_name'] . '</td>';
                        echo '<td>' . $row['quantity'] . '</td>';
                        echo '<td>' . $row['amount'] . '</td>';
                        echo '<td>' . $row['date_from'] . '</td>';
                        echo '<td>' . $row['date_to'] . '</td>';
                        echo '<td '.$class.'>'. $payment_status. '</td>';
                        echo '<td style="text-align:center;" class="crud-actions">';
                        echo '<a  href="' . site_url("kd2a2a0u1g4") . '/invoice/invoicepdf/' . $row['invoice_id'] . '" class="btn btn-info">view</a> 
                        </td>';
                        echo '</tr>';
                    }
                    ?>          
                </tbody>    
            </table>          
            <?php
            $this->session->set_userdata('redirect_url', current_url());
            echo '<div class="pagination">' . $this->pagination->create_links() . '</div>';
            ?>               
        </div>      
    </div>