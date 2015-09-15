<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

        <title>Invoice</title>
        <style>
            * { margin: 0; padding: 0; }
            body { font: 14px/1.4 Georgia, serif; }
            #page-wrap { width: 800px; margin: 0 auto; }

            textarea { border: 0; font: 14px Georgia, Serif; overflow: hidden; resize: none; }
            table { border-collapse: collapse; }
            table td, table th { border: 1px solid black; padding: 5px; }

            #header { height: 15px; width: 100%; margin: 20px 0; background: #222; text-align: center; color: white; font: bold 15px Helvetica, Sans-Serif; text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }

            #address { width: 250px; height: 150px; float: left; line-height:21px;}
            #customer { overflow: hidden; }

            #logo { text-align: right; float: right; position: relative; border: 1px solid #fff; max-width: 540px; max-height: 130px; overflow: hidden; }
            /*#logo:hover, #logo.edit { border: 1px solid #000; margin-top: 0px; max-height: 125px; }*/
            #logoctr { display: none; }
            /*#logo:hover #logoctr, #logo.edit #logoctr { display: block; text-align: right; line-height: 25px; background: #eee; padding: 0 5px;}*/
            #logohelp { text-align: left; display: none; font-style: italic; padding: 10px 5px;}
            #logohelp input { margin-bottom: 5px; }
            .edit #logohelp { display: block; }
            .edit #save-logo, .edit #cancel-logo { display: inline; }
            .edit #image, #save-logo, #cancel-logo, .edit #change-logo, .edit #delete-logo { display: none; }
            #customer-title {float: left;
                             font-size: 16px;
                             font-weight: bold;
                             height: 122px; }

            #meta { margin-top: 1px; width: 300px; float: right; }
            #meta td { text-align: right;  }
            #meta td.meta-head { text-align: left; background: #eee; }
            #meta td textarea { width: 100%; height: 20px; text-align: right; }

            #items { clear: both; width: 100%; margin: 30px 0 0 0; border: 1px solid black; }
            #items th { background: #eee; }
            #items textarea { width: 80px; height: 50px; }
            #items tr.item-row td { border: 0; vertical-align: top; text-align:center;}
            #items td.description { width: 300px; }
            #items td.item-name { width: 175px; }
            #items td.description textarea, #items td.item-name textarea { width: 100%; }
            #items td.total-line { border-right: 0; text-align: right; }
            #items td.total-value { border-left: 0; padding: 10px; }
            #items td.total-value textarea { height: 20px; background: none; }
            #items td.balance { background: #eee; }
            #items td.blank { border: 0; }

            #terms { text-align: center; margin: 20px 0 0 0; }
            #terms h5 { text-transform: uppercase; font: 13px Helvetica, Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
            #terms textarea { width: 100%; text-align: center;}

            textarea:hover, textarea:focus, #items td.total-value textarea:hover, #items td.total-value textarea:focus, .delete:hover { }

            .delete-wpr { position: relative; }
            .delete { display: block; color: #000; text-decoration: none; position: absolute; background: #EEEEEE; font-weight: bold; padding: 0px 3px; border: 1px solid; top: -6px; left: -22px; font-family: Verdana; font-size: 12px; }
            .btn {
                display: inline-block;
                padding: 4px 10px 4px;
                font-size: 13px;
                line-height: 18px;
                color: #333333;
                text-align: center;
                text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
                background-color: #fafafa;
                background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), color-stop(25%, #ffffff), to(#e6e6e6));
                background-image: -webkit-linear-gradient(#ffffff, #ffffff 25%, #e6e6e6);
                background-image: -moz-linear-gradient(top, #ffffff, #ffffff 25%, #e6e6e6);
                background-image: -ms-linear-gradient(#ffffff, #ffffff 25%, #e6e6e6);
                background-image: -o-linear-gradient(#ffffff, #ffffff 25%, #e6e6e6);
                background-image: linear-gradient(#ffffff, #ffffff 25%, #e6e6e6);
                background-repeat: no-repeat;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#e6e6e6', GradientType=0);
                border: 1px solid #ccc;
                border-bottom-color: #bbb;
                /*-webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 4px;*/
                /*-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
                -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);*/
                -webkit-box-shadow: 2px 4px 22px -7px black;
                -moz-box-shadow: 2px 4px 22px -7px black;
                box-shadow: 2px 4px 22px -7px black;
                cursor: pointer;
                *margin-left: .3em;
            }
            .btn_main{
                font-weight:bold;
                color:#ffffff !important
                    background-color: #FF8F28;
                background-image: -moz-linear-gradient(top, #FF8F28, #D1701E);
                background-image: -ms-linear-gradient(top, #FF8F28, #D1701E);
                background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#FF8F28), to(#D1701E));
                background-image: -webkit-linear-gradient(top, #FF8F28, #D1701E);
                background-image: -o-linear-gradient(top, #FF8F28, #D1701E);
                background-image: linear-gradient(top, #FF8F28, #D1701E);
                background-repeat: repeat-x;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FF8F28', endColorstr='#D1701E', GradientType=0);
                /*border-color:  #D1701E #D1701E #FF8F28;*/

                border-bottom-color:#FF8F28 !important;
                border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
                filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
                /* border-bottom:1px solid #FFA249;*/
                text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
                color: #ffffff;
            }
            @media print{
                #print { display:none;}
            }
        </style>
    </head>

    <body>
        <?php
//echo'<pre>'; print_r($invoice);exit;
//echo '</pre>';
        ?>
        <div style="width: 800px; margin: 0 auto;" id="page-wrap">
            <div style="float: right; margin-top: 20px; margin-bottom: 20px;"><button class="btn btn_main" onclick="printpage();" id="print">Print Invoice</button></div>
            <h1 style="clear:both;" id="header">INVOICE</h1>

            <div id="identity">

                <address style="border: 0; font: 14px Georgia, Serif; overflow: hidden; resize: none;" id="address">Knewdog!<br/>
                    a service of Cactus Competence Ltd.<br />
                    Unit B, 5/F, Yat Chau Building<br />
                    262 Des Voeux Road<br/>
                    Central<br />
                    Hong Kong</address>

                <div id="logo">

                    <!--<div id="logoctr">
                      <a href="javascript:;" id="change-logo" title="Change logo">Change Logo</a>
                      <a href="javascript:;" id="save-logo" title="Save changes">Save</a>
                      |
                      <a href="javascript:;" id="delete-logo" title="Delete logo">Delete Logo</a>
                      <a href="javascript:;" id="cancel-logo" title="Cancel changes">Cancel</a>
                    </div>-->

                    <!--<div id="logohelp">
                      <input id="imageloc" type="text" size="50" value="" /><br />
                      (max width: 540px, max height: 100px)
                    </div>-->
                    <img id="image" src="<?php echo site_url('assets/img/logo_inner.png') ?>" alt="Knewdog!" />
                </div>

            </div>

            <div style="clear:both"></div>

            <div id="customer">

                <div style="border: 0; font: 14px Georgia, Serif; overflow: hidden; resize: none;" id="customer-title"><b>Billed To,</b><br />
                    <?php echo $invoice[0]['first_name'] ?> 
                    <?php echo $invoice[0]['last_name'] ?><br /> 
                    <?php echo $invoice[0]['address1'] ?><br />
                    <?php echo $invoice[0]['address2'] ?> <br />
                    <?php echo $invoice[0]['city'] ?> <br />
                    <?php echo $invoice[0]['country'] ?> <br />
                    Zip: <?php echo $invoice[0]['zip'] ?></div>

                <table style="border-collapse: collapse;" id="meta">
                    <tr>
                        <td class="meta-head">Invoice #</td>
                        <td><textarea style="border: 0; font: 14px Georgia, Serif; overflow: hidden; resize: none;"><?php echo $invoice[0]['item_number'] ?></textarea></td>
                    </tr>
                    <tr>

                        <td class="meta-head">Date</td>
                        <td><textarea style="border: 0; font: 14px Georgia, Serif; overflow: hidden; resize: none;" id="date"><?php echo date('F, j Y', strtotime($invoice[0]['payment_date'])) ?></textarea></td>
                    </tr>
                    <tr>
                        <td class="meta-head">Amount</td>
                        <td><div class="due">$<?php echo (($invoice[0]['quantity']) * ($invoice[0]['amount'])) ?></div></td>
                    </tr>

                </table>

            </div>

            <table id="items">

                <tr>
                    <th>Item</th>
                    <th>Timing</th>
                    <th>Unit Cost</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>

                <tr class="item-row">
                    <td class="item-name"><div class="delete-wpr"><span><?php echo $invoice[0]['item_name'] ?></span><!--<a class="delete" href="javascript:;" title="Remove row">X</a>--></div></td>
                    <td class="description"><span>From <?php echo date('F j, Y', strtotime($invoice[0]['date_from'])) ?> to <?php echo date('F j, Y', strtotime($invoice[0]['date_to'])) ?></span></td>
                    <td><span class="cost">$<?php echo $invoice[0]['amount'] ?></span></td>
                    <td><span class="qty"><?php echo $invoice[0]['quantity'] ?></span></td>
                    <td><span class="price">$<?php echo (($invoice[0]['quantity']) * ($invoice[0]['amount'])) ?></span></td>
                </tr>
                 <!-- <tr id="hiderow">
                  <td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
                </tr>
                -->
                <!--<tr>
                    <td colspan="2" class="blank"> </td>
                    <td colspan="2" class="total-line">Subtotal</td>
                    <td class="total-value"><div id="subtotal">$875.00</div></td>
                </tr>-->
                <tr>

                    <td colspan="2" class="blank"> </td>
                    <td colspan="2" class="total-line">Total</td>
                    <td class="total-value"><div id="total">$<?php echo (($invoice[0]['quantity']) * ($invoice[0]['amount'])) ?></div></td>
                </tr>
                <!--<tr>
                    <td colspan="2" class="blank"> </td>
                    <td colspan="2" class="total-line">Amount Paid</td>

                    <td class="total-value"><textarea id="paid">$0.00</textarea></td>
                </tr>-->
                <tr>
                    <?php 
                    if($invoice[0]['status']=="pending"){
                        $payment_status="failed";
                        $class ='style="color:red"';
                    }else{
                        $payment_status = $invoice[0]['status'];
                        $class ='style="color:black"';
                    }
                ?>
                    <td >Payment Status</td>
                    <td <?php echo $class;?>> <?php echo $payment_status; ?></td>
                    <td colspan="2" class="total-line balance">Total Amount</td>
                    <td class="total-value balance"><div class="due">$<?php echo (($invoice[0]['quantity']) * ($invoice[0]['amount'])) ?></div></td>
                </tr>

            </table>

            <div id="terms">
                <h5 style=" letter-spacing:2px;"><a style="color:#000000;font-weight:bold; " href="<?php echo site_url(); ?>">Knewdog!</a></h5>
                <textarea style="border: 0; font: 14px Georgia, Serif; overflow: hidden; resize: none;"></textarea>
            </div>

        </div>
        <script> function printpage() {
                    window.print();
                }</script>	
    </body>

</html>