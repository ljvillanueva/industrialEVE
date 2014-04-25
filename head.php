<?php
/*
$absolute_dir=dirname(__FILE__);
$absolute_dir = preg_replace('/include$/', '', $absolute_dir);
$app_dir = substr($absolute_dir, strlen($_SERVER['DOCUMENT_ROOT']));
$app_url = "http://" . $_SERVER['SERVER_NAME'] . $app_dir;
*/

#Jita
$system_id = 30000142;

?>
<!doctype html>
<html lang="us">
<head>
	<meta charset="utf-8">
	<title>EVE Industrial</title>
	<link href="libs/jqueryui/css/humanity/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	<script src="libs/jqueryui/js/jquery-1.9.1.js"></script>
	<script src="libs/jqueryui/js/jquery-ui-1.10.3.custom.js"></script>
	

<!-- Bootstrap -->  
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="libs/bootstrap/css/sticky-footer-navbar.css" rel="stylesheet">
	<script src="libs/bootstrap/js/bootstrap.min.js"></script>

<!-- D3 -->  
<!-- 
    <script type="text/javascript" src="libs/d3/d3.js"></script>
    <script type="text/javascript" src="libs/d3/d3.csv.js"></script>
    <script type="text/javascript" src="libs/d3/d3.time.js"></script>
-->  

<script type="text/javascript" src="libs/flotr2/flotr2.min.js"></script>


<!-- https://github.com/joequery/Stupid-Table-Plugin/blob/master/examples/basic.html -->
<script src="libs/Stupid-Table-Plugin/stupidtable.js?dev"></script>

<script>
    $(function(){
        $("table").stupidtable();
    });
  </script>
  <style type="text/css">
    table {
      border-collapse: collapse;
    }
    th, td {
      padding: 5px 10px;
      border: 1px solid #999;
    }
    th {
      background-color: #eee;
    }
    th[data-sort]{
      cursor:pointer;
    }
    tr.awesome{
      color: red;
    }
  </style>
 
