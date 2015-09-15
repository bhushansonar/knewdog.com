<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("kd2a2a0u1g4/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a> 
            <span class="divider">/</span>
        </li>
        <li class="active">
            comment<?php //echo ucfirst($this->uri->segment(2));  ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            comment<?php //echo ucfirst($this->uri->segment(2));  ?> 

        </h2>
    </div>
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
            echo '<strong>Well done!</strong> new comment created with success.';
            echo '</div>';
        } else if ($this->session->flashdata('flash_message') == 'update') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> comment updated with success.';
            echo '</div>';
        } else if ($this->session->flashdata('flash_message') == 'delete') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> comment deleted with success.';
            echo '</div>';
        } else if ($this->session->flashdata('flash_message') == 'clone') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> One comment cloned with success.';
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
                foreach ($comment as $array) {
                    foreach ($array as $key => $value) {
                        $options_language[$key] = $key;
                    }
                    break;
                }

                echo form_open('kd2a2a0u1g4/comment', $attributes);

                echo form_label('Search:', 'search_string');
                echo form_input('search_string', $search_string_selected);
                ?>
                <select name="order" class="span2">
                    <option <?php echo ($order == 'comment.name') ? 'selected="selected"' : "" ?>  value="comment.name">Name</option>
                    <option <?php echo ($order == 'comment.email') ? 'selected="selected"' : "" ?>  value="comment.email">E-mail</option>
                    <option <?php echo ($order == 'blog.title_en') ? 'selected="selected"' : "" ?>  value="blog.title_en">Blog</option>
                    <option <?php echo ($order == 'comment.status') ? 'selected="selected"' : "" ?> value="comment.status">Status</option>
                                    <!--<option <?php echo ($order == 'block_name') ? 'selected="selected"' : "" ?> value="block_name">Block name</option>-->
                </select>
                <?php
                echo form_label('Order by:', 'order');
//echo form_dropdown('order', $options_language, $order, 'class="span2"');

                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

                echo form_submit($data_submit);
                if ($search_string_selected) {
                    echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="' . site_url("kd2a2a0u1g4/comment/") . '">Reset</a>';
                }
                echo form_close();
                ?>

            </div>

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="header">#</th>
                        <th class="yellow header headerSortDown">Name</th>
                        <th class="yellow header headerSortDown">E-mail</th>
                        <th class="yellow header headerSortDown">Blog</th>

                        <th class="yellow header headerSortDown">Date</th>
                        <th class="yellow header headerSortDown">Status</th>
                        <th style="width:266px;" class="yellow header headerSortDown"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($comment as $row) {
                        $statusbtn = ($row['status'] == 'Active') ? 'Unapproved' : 'Approved';
                        $status = ($row['status'] == 'Active') ? 'Approved' : 'Unapproved';

                        echo '<tr>';
                        echo '<td>' . $row['comment_id'] . '</td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        echo '<td>' . $row['title_en'] . '</td>';

                        echo '<td>' . date("j, F Y", strtotime($row['date'])) . '</td>';
                        echo '<td>' . $status . '</td>';
                        //html_entity_decode($row['en'])
                        echo '<td style="text-align:center;" class="crud-actions">
                  <a href="' . site_url("kd2a2a0u1g4") . '/comment/status/' . $row['comment_id'] . '" class="btn btn-info">Click to ' . $statusbtn . '</a>
				  <a href="' . site_url("kd2a2a0u1g4") . '/comment/update/' . $row['comment_id'] . '" class="btn btn-primary">Edit</a>
				   <a href="' . site_url("kd2a2a0u1g4") . '/comment/delete/' . $row['comment_id'] . '" class="btn btn-danger complexConfirm">delete</a>
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