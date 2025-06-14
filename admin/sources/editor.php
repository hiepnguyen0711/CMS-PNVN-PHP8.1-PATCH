<?php
	require_once 'ckeditor/ckeditor.php';
	require_once 'ckfinder/ckfinder.php';
	$ckeditor = new CKEditor();
	$ckeditor->basePath = 'ckeditor';
	CKFinder::SetupCKEditor($ckeditor, 'ckfinder/');
?>
<script language="JavaScript" type="text/javascript" src="ckeditor/ckeditor.js"></script>
<!-- <script>CKEDITOR.env.isCompatible = true;</script> -->
