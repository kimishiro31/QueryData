<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title><?php echo $config['site_title']; ?></title>
		<meta name="description" content="<?php echo $config['site_description']; ?>" />
		<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=10, minimum-scale=1.0">
		<link rel="icon" href="layout/images/icon.ico">
		
		<!-- Stylesheet(s) -->
		<link rel="stylesheet" type="text/css" href="/layout/overall/header/header.css" />
		<link rel="stylesheet" type="text/css" href="/layout/overall/menu/style.css" />
		<link rel="stylesheet" type="text/css" href="/layout/overall/footer/footer.css" />
		<link rel="stylesheet" type="text/css" href="/layout/overall/others/inputs.css" />
		<link rel="stylesheet" type="text/css" href="/layout/overall/others/labels.css" />
		<link rel="stylesheet" type="text/css" href="/layout/overall/others/popups.css" />
		<link rel="stylesheet" type="text/css" href="/layout/overall/others/animations.css" />
		<link rel="stylesheet" type="text/css" href="/layout/overall/others/tables.css" />
		<link rel="stylesheet" type="text/css" href="/layout/overall/others/tippeds.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<!-- JavaScript(s) -->
		
		<script type="text/javascript" src="/layout/js/jquery.min.js"></script>
		<script type="text/javascript" src="/layout/js/jquery.sooperfish.js"></script>
		<script type="text/javascript" src="/layout/js/tipped.js"></script>
		<script type="text/javascript" src="/layout/js/jquery.mask.js"></script>
		<script type="text/json" src="/layout/js/composer.json"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<!--		<script type="text/javascript" src="/layout/js/jquery-3.6.0.min.js"></script>
		<script type="text/json" src="/layout/js/composer.json"></script>-->

		<!-- SVG(s) -->
		
		<!-- Json(s) -->

		<!-- Script(s) -->
		<script src="layout\js\functions.js"></script>
	</head>
	<body>
		<!-- Main container -->
		<header>
			<?php include 'layout/overall/menu/headerMenu.php'; ?>
		</header>
		<main>
			<aside id="body">
				<!-- MAIN FEED -->
					<div id="border-content">
					<!-- <div id="title-border"><img src="layoutDesign/titlebar.png"/><p id="title-page"><?php //echo $titlepage ?></p></div>-->
						<div id="content">
