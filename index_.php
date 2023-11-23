<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
    	html, body {
    		height: 100%;
    		margin: 0;
    	}

    	#wrapper {
	position: fixed;
  	top: 0;
  	left: 0;
  	bottom: 0;
  	right: 0;
  	overflow: auto;
  	 /* background: lime; Just to visualize the extent */
    	}
    #sidemenu {
	height: 100%;
	width: 25%;
	border-right-width: 1px;
	border-right-color: #CCC;
	background-color: #FFF;
	float: left;
	border-right-style: solid;
}
#contentmenu {
	height: 100%;
	width: 100%;
	background-color: #f1eff0;
}
#sidemenutop {
	height: 75%;
}
#sidemenudown {
	height: 25%;
	background-color: #CCC;
}
#sidemenulogo {
	height: 50px;
	background-color: #666;
	font-family: Calibri;
	font-size: 12px;
	line-height: 50px;
	color: #FFF;
}
#sidecontenttop {
	height: 50px;
	line-height: 50px;
	background-color: #555;
}
.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(content/images/page-loader.gif) 50% 50% no-repeat rgb(249,249,249);
}
</style>
    <!--[if lte IE 6]>
    <style type="text/css">
    	#container {
    		height: 100%;
    	}
    </style>
    <![endif]-->
<script src="content/js/jquery.min.js"></script>
<script type="text/javascript">
$(window).load(function() {
	$(".loader").fadeOut("slow");
})
</script>
</head>

<body>
<div class="loader"></div>
<div id="wrapper">
  <div id="sidemenu">
    <div id="sidemenutop">
      <div id="sidemenulogo">
        <div align="center"><img src="content/images/logo.png" width="220" height="50" /></div>
      </div>
    </div>
    <div id="sidemenudown"></div>
  </div>
  <div id="contentmenu">
    <div id="sidecontenttop"></div>
  </div>
</div>
</body>
</html>