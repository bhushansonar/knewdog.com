<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("kd2a2a0u1g4/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            Website advertisement<?php //echo ucfirst($this->uri->segment(2));  ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            Website advertisement<?php //echo ucfirst($this->uri->segment(2));  ?>
            <a  href="<?php echo site_url("kd2a2a0u1g4") . '/' . $this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
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
            echo '<strong>Well done!</strong> new Website advertisement created with success.';
            echo '</div>';
        } else if ($this->session->flashdata('flash_message') == 'update') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Website advertisement updated with success.';
            echo '</div>';
        } else if ($this->session->flashdata('flash_message') == 'delete') {
            echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> Website advertisement deleted with success.';
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


            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="header">#</th>
                        <th class="yellow header headerSortDown">Website advertisement script</th>
                        <th class="yellow header headerSortDown">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($wanted_add as $row) {
                        $status = ($row['status'] == 'Active') ? 'Inactive' : 'Active';
                        echo '<tr>';
                        echo '<td>' . $row['wanted_add_id'] . '</td>';
                        echo '<td>' . $row['wanted_add_script'] . '</td>';
                        echo '<td>' . $row['status'] . '</td>';
                        echo '<td style="width:215px;" class="crud-actions">
                  <a  href="' . site_url("kd2a2a0u1g4") . '/wanted-add/update/' . $row['wanted_add_id'] . '" class="btn btn-info">view & edit</a>

                  <a href="' . site_url("kd2a2a0u1g4") . '/wanted-add/delete/' . $row['wanted_add_id'] . '" class="btn btn-danger complexConfirm">delete</a>
                </td>';
                        echo '</tr>';
                    }
// <a href="'.site_url("kd2a2a0u1g4").'/wanted-add/status/'.$row['wanted_add_id'].'" class="btn btn-primary">'.$status.'</a>
                    ?>
                </tbody>
            </table>
            <?php
            $this->session->set_userdata('redirect_url', current_url());
            echo '<div class="pagination">' . $this->pagination->create_links() . '</div>';
            ?>

        </div>
    </div>