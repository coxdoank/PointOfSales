<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}
.modal-02 {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 500px; /* Full width */
    height: auto; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content-02 {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.btn_payment {
	font-size: 33px;
	text-decoration: none;
	width: 2.2em;
	background-color: #50a8f2;
	border: 1px solid #ababab;
	color: #FFF;
	float: left;
	margin-right: 1%;
	height: 2.2em;
}
</style>
<link href="../content/css/stylesheet.css" rel="stylesheet" type="text/css" />
</head>
<body>

<h2>Modal Example</h2>

<!-- Trigger/Open The Modal -->
<button id="myBtn">Open Modal</button>

<!-- Start Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">×</span>
    
    <table width="100%" align="center">
    <tr>
      <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
          <td colspan="2" class="label_dashboard">Pembayaran</td>
          </tr>
        <tr>
          <td><span class="label_dashboard_text">Total Transaksi</span></td>
          <td align="right"><span class="label_dashboard">
            <input name="textfield" type="text" class="input_underline" id="textfield" value="<?php echo "$rwdisp[AMOUNT]" ?>" />
          </span></td>
        </tr>
        <tr>
          <td><span class="label_dashboard_text">Tunai</span></td>
          <td align="right"><span class="label_dashboard">
            <input name="code" type="text" class="input_underline" value="" />
          </span></td>
        </tr>
        <tr>
          <td class="label_dashboard_text">Kembali</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><hr /></td>
          </tr>
        <tr>
          <td class="label_dashboard_text">Status Pesanan</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td class="label_dashboard_text">Catatan Pesanan</td>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td class="label_dashboard_text">Pelanggan</td>
          <td align="right">&nbsp;</td>
        </tr>
      </table></td>
      <td width="20%" align="right" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
          <td width="80%" align="right"><input name="btn01" type="button" onclick="addCode('1');" class="btn_payment" id="1" value="1" /></td>
          <td width="80%" align="right"><input name="btn02" type="button" onclick="addCode('2');" class="btn_payment" id="btn02" value="2" /></td>
          <td width="80%" align="right"><input name="btn03" type="button" onclick="addCode('3');" class="btn_payment" id="btn03" value="3" /></td>
        </tr>
        <tr>
          <td align="right"><input name="btn04" type="button" onclick="addCode('4');" class="btn_payment" id="btn04" value="4" /></td>
          <td align="right"><input name="btn05" type="button" onclick="addCode('5');" class="btn_payment" id="btn05" value="5" /></td>
          <td align="right"><input name="btn06" type="button" onclick="addCode('6');" class="btn_payment" id="btn06" value="6" /></td>
        </tr>
        <tr>
          <td align="right"><input name="btn07" type="button" onclick="addCode('7');" class="btn_payment" id="btn07" value="7" /></td>
          <td align="right"><input name="btn08" type="button" onclick="addCode('8');" class="btn_payment" id="btn08" value="8" /></td>
          <td align="right"><input name="btn09" type="button" onclick="addCode('9');" class="btn_payment" id="btn09" value="9" /></td>
        </tr>
        <tr>
          <td align="right"><input name="btn_clear" type="reset"  class="btn_payment" id="btn_clear" value="Del" /></td>
          <td align="right"><input name="btn00" type="button" onclick="addCode('0');" class="btn_payment" id="btn00" value="0" /></td>
          <td align="right"><input name="submit" type="submit"  class="btn_payment" id="submit" value="Pay" /></td>
        </tr>
      </table></td>
    </tr>
  </table>
    
  </div>
</div>
<!-- End Modal -->

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</body>
</html>