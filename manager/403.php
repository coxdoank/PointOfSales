<?php include "../connection/connDB.php"; ?>
<?php include "../connection/function.php"; ?>
<?php include "header.php"; ?>

<!--main-container-part-->
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Sample pages</a> <a href="#" class="current">Error</a> </div>
    <h1>Error 403</h1>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Error 403</h5>
          </div>
          <div class="widget-content">
            <div class="error_ex">
              <h1>403</h1>
              <h3>Opps, You're lost.</h3>
              <p>Access to this page is forbidden</p>
              <a class="btn btn-warning btn-big"  href="index.html">Back to Home</a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--end-main-container-part-->

<?php include "footer.php"; ?>
<?php include "footer_script.php"; ?>