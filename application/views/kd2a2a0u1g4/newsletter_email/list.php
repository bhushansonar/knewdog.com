<div class="container top">        
	<ul class="breadcrumb">   
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
                foreach ($newsletter_email as $array) {
                    foreach ($array as $key => $value) {
                        $options_keyword[$key] = $key;
                    } break;
                } echo form_open('kd2a2a0u1g4/newsletter_email', $attributes);
                echo form_label('Search:', 'search_string');
                echo form_input('search_string', $search_string_selected);
                ?>                               
                <select name="order" class="span2">   
                    <option <?php echo ($order == 'email') ? 'selected="selected"' : "" ?> value="email">Email</option> 
                </select>              
                <?php
                echo form_label('Order by:', 'order');
                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');
                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');
                echo form_submit($data_submit);
                if ($search_string_selected) {
                    echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="' . site_url("kd2a2a0u1g4/newsletter_email") . '">Reset</a>';
                } echo form_close();
                ?>        
            </div>    
            <table class="table table-striped table-bordered table-condensed">   
                <thead>         
                    <tr>       
                        <th class="header">#</th>     
                        <th class="yellow header headerSortDown">Email</th>  
                        <th class="yellow header headerSortDown">Password</th>    
                    </tr>          
                </thead>          
                <tbody>      
                    <?php
                    foreach ($newsletter_email as $key => $row) {

                       
                        echo '<tr>';
                        echo '<td>' . $row['newsletter_email_id'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        echo '<td>' . decrypt($row['password']) . '</td>';
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