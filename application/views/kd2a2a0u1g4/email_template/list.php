<style>
    .align{
        text-align: center;
    }
</style>
<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("kd2a2a0u1g4/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a> 
            <span class="divider">/</span>
        </li>
        <li class="active">
            Email Template<?php //echo ucfirst($this->uri->segment(2));   ?>
        </li>
    </ul>

    <!--      <div class="page-header users-header">
            <h2>
              Email Template<?php //echo ucfirst($this->uri->segment(2));   ?> 
              <a  href="<?php echo site_url("kd2a2a0u1g4") . '/' . $this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
            </h2>
          </div>-->
    <?php
    //\\print_r($this->session->userdata('flash_message'));
    //print_r($this->session->flashdata('data'));
    //flash messages

    echo validation_errors();
    //echo $this->session->flashdata('flash_message');
    if ($this->session->flashdata('flash_message')) {
        if ($this->session->flashdata('flash_message') == 'add') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> new Email template created with success.';
            echo '</div>';
        } else if ($this->session->flashdata('flash_message') == 'update') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Email template updated with success.';
            echo '</div>';
        } else if ($this->session->flashdata('flash_message') == 'delete') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Email template deleted with success.';
            echo '</div>';
        } else if ($this->session->flashdata('flash_message') == 'clone') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> One Email template cloned with success.';
            echo '</div>';
        } else {
            echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
            echo '</div>';
        }
    }
    ?>
    <div class="row">
        <div class="span12 columns">
            <div class="well">

                <?php
                $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');

//save the columns names in a array that we will use as filter         
                $options_language = array();

                foreach ($email_template as $array) {
                    foreach ($array as $key => $value) {
                        $options_language[$key] = $key;
                    }
                    break;
                }

                echo form_open('kd2a2a0u1g4/email_template', $attributes);

                echo form_label('Search:', 'search_string');
                echo form_input('search_string', $search_string_selected);
                ?>
                <select name="order" class="span2">
                    <option <?php echo ($order == 'subject_en') ? 'selected="selected"' : "" ?>  value="subject_en">Subject</option>
                    <option <?php echo ($order == 'status') ? 'selected="selected"' : "" ?> value="status">Status</option>
                                    <!--<option <?php echo ($order == 'block_name') ? 'selected="selected"' : "" ?> value="block_name">Block name</option>-->
                </select>
                <?php
                echo form_label('Order by:', 'order');
                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

                echo form_submit($data_submit);
                if ($search_string_selected) {
                    echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="' . site_url("kd2a2a0u1g4/email_template/") . '">Reset</a>';
                }
                echo form_close();
                ?>

            </div>

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="header">#</th>
                        <th class="yellow header headerSortDown">Subject</th>
                        <th class="yellow header headerSortDown">Status</th>
                        <th style="width:211px; text-align: center;" class="yellow header headerSortDown">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($email_template as $row) {

                        echo '<tr>';
                        echo '<td>' . $row['email_template_id'] . '</td>';
                        echo '<td>' . $row['subject_en'] . '</td>';
                        echo '<td>' . $row['status'] . '</td>';
                        echo '<td style="text-align:center">
                  <a  href="' . site_url("kd2a2a0u1g4") . '/email_template/update/' . $row['email_template_id'] . '" class="btn btn-info"> view & edit</a>  
                 
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