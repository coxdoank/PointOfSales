<?php 
include "connection/connDB.php";
include "connection/function.php";
include "login_session.php";

$mod	= isset($_GET['mod']) ? $_GET['mod'] : '';
$act	= isset($_GET['act']) ? $_GET['act'] : '';
$cat	= isset($_GET['cat']) ? $_GET['cat'] : '';
$id	 	= isset($_GET['id']) ? $_GET['id'] : '';
$idm	= isset($_GET['idm']) ? $_GET['idm'] : '';
$idtr	= isset($_POST['idtr']) ? $_POST['idtr'] : '';

// restaurant
$qres = "select * from restaurant";
$qres = mysqli_query($connection,$qres);
$row = mysqli_fetch_array($qres);

//data ticket 
$qticket = mysqli_query($connection,"select * from ticket tic
left join user usr on usr.USER_ID = tic.ID_USER
where tic.TERMINAL = '$terminal' and tic.NO_TRANSACTION = '$id'");
$rows = mysqli_fetch_array($qticket);

//data ticket item 
$qtrans = mysqli_query($connection,"SELECT * from ticket_item ttm                                  
left join ticket tic on tic.NO_TRANSACTION = ttm.NO_TRANSACTION
WHERE ttm.TERMINAL = '$terminal' and ttm.NO_TRANSACTION = '$id'");

//mysqli_query($connection,"update ticket set STATUS = 'CLOSE' where TERMINAL = '$terminal' and CLOSING_DATE is NULL and AMOUNT is NULL and TENDER_AMOUNT is NULL and DUE_AMOUNT is NULL and STATUS = 'OPEN'");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'PT Sans', sans-serif;
        }

        @page {
            size: 2.8in 11in;
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
        }

        table {
            width: 100%;
        }

        tr {
            width: 100%;

        }

        h1 {
            text-align: center;
            vertical-align: middle;
        }

        #logo {
            width: 60%;
            text-align: center;
            -webkit-align-content: center;
            align-content: center;
            padding: 5px;
            margin: 2px;
            display: block;
            margin: 0 auto;
        }

        header {
            width: 100%;
            text-align: center;
            -webkit-align-content: center;
            align-content: center;
            vertical-align: middle;
        }

        .items thead {
            text-align: center;
        }

        .center-align {
            text-align: center;
        }

        .bill-details td {
            font-size: 12px;
        }

        .receipt {
            font-size: medium;
        }

        .items .heading {
            font-size: 12.5px;
            text-transform: uppercase;
            border-top:1px solid black;
            margin-bottom: 4px;
            border-bottom: 1px solid black;
            vertical-align: middle;
        }

        .items thead tr th:first-child,
        .items tbody tr td:first-child {
            width: 47%;
            min-width: 47%;
            max-width: 47%;
            word-break: break-all;
            text-align: left;
        }

        .items td {
            font-size: 12px;
            text-align: right;
            vertical-align: bottom;
        }

        .price::before {
             /* content: "\20B9"; */
            font-family: Arial;
            text-align: right;
        }

        .sum-up {
            text-align: right !important;
        }
        .total {
            font-size: 13px;
            border-top:1px dashed black !important;
            border-bottom:1px dashed black !important;
        }
        .total.text, .total.price {
            text-align: right;
        }
        .total.price::before {
            /* content: "\20B9";  */
        }
        .line {
            border-top:1px solid black !important;
        }
        .heading.rate {
            width: 20%;
        }
        .heading.amount {
            width: 25%;
        }
        .heading.qty {
            width: 5%
        }
        p {
            padding: 1px;
            margin: 0;
        }
        section, footer {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <header>
    <?php if($row['LOGO'] == "Y"){ echo "<img src='content/images/logo-odaba.png' width='150' height='150' />"; }else{ echo "<p>$row[NAME]</p>"; } ?>

    </header>
    <p>Struk # <?php echo "$rows[NO_TRANSACTION]" ?></p>
    <table class="bill-details">
        <tbody>
            <tr>
                <td>Date : <span><?php echo "$rows[CLOSING_DATE]" ?> WIB</span></td>
                <!-- <td>Time : <span>2</span></td> -->
            </tr>
            <tr>
                <td>Terminal #: <span><?php echo "$rows[TERMINAL]" ?></span></td>
                <td>Kasir # : <span><?php if(empty($rows['FIRST_NAME'])){ echo $rows['LAST_NAME']; }else{ echo $rows['FIRST_NAME']; } ?></span></td>
            </tr>
            <!-- <tr>
                <th class="center-align" colspan="2"><span class="receipt">List Order</span></th>
            </tr> -->
        </tbody>
    </table>
    
    <table class="items">
        <thead>
            <tr>
                <th class="heading name">Item</th>
                <!-- <th class="heading qty">Qty</th> -->
                <th class="heading amount">Total</th>
            </tr>
        </thead>
        <?php while($rwtrs=mysqli_fetch_array($qtrans)){ ?>
        <tbody>
            <tr>
                <td><?php echo "$rwtrs[ITEM_NAME]" ?> (<?php echo "$rwtrs[ITEM_COUNT]" ?> x Rp<?php echo number_format($rwtrs['ITEM_PRICE']) ?>)</td>
                <!-- <td><?php echo "$rwtrs[ITEM_COUNT]" ?></td> -->
                <td class="price"><?php echo number_format($rwtrs['SUB_TOTAL']) ?></td>
            </tr>
            <?php } ?>
            <!-- <tr>
                <td>Non-Veg Focaccoa S/W</td>
                <td>2</td>
                <td class="price">600.00</td>
            </tr>
            <tr>
                <td>Classic mojito</td>
                <td>1</td>
                <td class="price">800.00</td>
            </tr>
            <tr>
                <td>Non-Veg Ciabatta S/W</td>
                <td>1</td>
                <td class="price">500.00</td>
            </tr> -->
            <tr>
                <td class="sum-up line">Subtotal</td>
                <td class="line price"><?php echo number_format($rows['AMOUNT']) ?></td>
            </tr>
            <tr>
                <td class="sum-up">Tunai</td>
                <td class="price"><?php echo number_format($rows['TENDER_AMOUNT']) ?></td>
            </tr>
            <!-- <tr>
                <td class="sum-up">Kembali</td>
                <td class="price"><?php echo number_format($rows['DUE_AMOUNT']) ?></td>
            </tr> -->
            <tr>
                <th class="total text">Kembali</th>
                <th class="total price"><?php echo number_format($rows['DUE_AMOUNT']) ?></th>
            </tr>
        </tbody>
    </table>
    <br>

    <!-- <section>
        <p>
            Paid by : <span>CASH</span>
        </p>
        <p style="text-align:center">
            Thank you for your visit!
        </p>
    </section> -->
    <footer style="text-align:center">
        <p><?php echo "$row[TICKET_FOOTER]" ?></p>
        <!-- <p>www.dotworld.in</p> -->
    </footer>
</body>

</html>