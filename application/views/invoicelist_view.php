<main>
    <?php
    //echo '<pre>';print_r($this->session->userdata);
    //echo '<pre>';print_r($_COOKIE);
    //echo $_SESSION['token'];
    //echo '<pre>';	print_r($guser);
    ?>
    <div class="set_errors">
        <?php
        echo validation_errors();
        if ($this->session->flashdata('flash_message')) {
            echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
            echo '</div>';
        }
        ?>
    </div>
    <section class="homepage" id="container">
        <div class="page_helptitle">
            <h2 style="width: 80%;"><?php echo _clang(INVOICE_LIST); ?></h2>


        </div>
        <a style="float: right; margin: 29px 0px 0px; color:#FFF !important;" class="btn btn_main" onclick="submitform('gotoaccountsetting')" href="javascript:void(0)"><?php echo _clang(BACK); ?></a>
        <form id="gotoaccountsetting" action="<?php echo site_url('myknewdog'); ?>" method="post">
            <input type="hidden" name="form" value="section_4" /> 
        </form> 
        <div class="homepage_inner invoice">

            <table style="" width=90% cellpadding="6" cellspacing="0">
                <tr>
                    <th><?php echo _clang(INVOICE_NUMBER); ?></th>
                    <th><?php echo _clang(ITEM_NAME); ?></th>

                    <?php /* ?><th>Email</th>
                      <th>Amount</th>
                      <th>Quantity</th><?php */ ?>
                    <th><?php echo _clang(TOTAL); ?></th>
                    <th><?php echo _clang(PAYMENT_STATUS); ?></th>
                    <th><?php echo _clang(DATE); ?></th>
                    <th><?php echo _clang(INVOICE); ?></th>
                </tr>
                <?php if (count($invoice) > 0) { ?>
                    <?php
                    for ($i = 0; $i < count($invoice); $i++) {
                        $tableeven = ($i % 2 == 0) ? "tableodd" : "tableeven";
                        ?>
                        <?php
                        if ($invoice[$i]['status'] == "pending") {
                            $payment_status = "failed";
                            $class = 'style="color:red"';
                        } else {
                            $payment_status = $invoice[$i]['status'];
                            $class = 'style="color:black"';
                        }
                        ?>
                        <tr>
                            <td class="<?php echo $tableeven ?>"><?php echo $invoice[$i]['item_number'] ?></td>
                            <td class="<?php echo $tableeven ?>"><?php echo $invoice[$i]['item_name'] ?></td>
                            <td class="<?php echo $tableeven ?>"><?php echo (($invoice[$i]['quantity']) * ($invoice[$i]['amount'])) ?></td>
                            <td <?php echo $class; ?> class="<?php echo $tableeven ?>"><?php echo $payment_status ?></td>
                            <td class="<?php echo $tableeven ?>"><?php echo date("j, F Y", strtotime($invoice[$i]['payment_date'])) ?></td>
                            <td class="<?php echo $tableeven ?>"><a target="_blank" href="<?php echo site_url('myknewdog/invoicepdf/' . $invoice[$i]['invoice_id']) ?>"><?php echo _clang(VIEW); ?></a></td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="8" style="text-align:center; line-height:80px; font-weight:bold;"><?php echo _clang(NO_INVOICE); ?></td>
                    </tr>
<?php } ?> 
            </table>
        </div>
    </section>
</main>