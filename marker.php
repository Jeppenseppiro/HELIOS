<?php
	require 'db_connect.php';

	$marker = $_GET["object"];
	echo $marker;

	$check_primary = "SELECT * FROM tbl_primary WHERE segment_id = '$marker'";
	$check_primaryQuery = $conn->query($check_primary);

	$check_secondary = "SELECT * FROM tbl_secondary WHERE distribution_lineid = '$marker'";
	$check_secondaryQuery = $conn->query($check_secondary);

	$check_transformer = "SELECT * FROM tbl_transformer WHERE distribution_transformerid = '$marker'";
	$check_transformerQuery = $conn->query($check_transformer);

	if($check_primaryQuery->num_rows > 0){
		header("location: primary.php?object=".$marker);
	} else if($check_secondaryQuery->num_rows > 0){
		header("location: secondary.php?object=".$marker);
	} else if($check_transformerQuery->num_rows > 0){
		header("location: transformer.php?object=".$marker);
	}
?>