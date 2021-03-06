<!doctype html>
<?php
require_once("php_includes/base.inc.php");
if(!hasPerm("officer")){
	redirect("/index.php");
	die();
}
$stmt = $pdo->prepare("SELECT * FROM `warrants` WHERE `active` = 0 ORDER BY `id` DESC");
$stmt->execute();
$warrants = $stmt->fetchAll();
$acnt = count($warrants);
$cminfo = getInfo("cminfo");
$cminfo = json_decode($cminfo['data'], true);
?>
<html lang="en-US">
	<head>

		<!-- Meta -->
		<meta charset="UTF-8">
		<title><?php echo $cminfo['pda']; ?> - Active Warrants</title>
		<meta name="description" content="<?php echo $cminfo['pdn']; ?> - Active Warrants">
		<meta name="author" content="Cole, Scott Harm (Retired)">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Favicons -->
		<link rel="shortcut icon" href="img/favicons/favicon.png">
		<link rel="apple-touch-icon" href="img/favicons/icon.png">
		<link rel="apple-touch-icon" sizes="72x72" href="img/favicons/72x72.png">
		<link rel="apple-touch-icon" sizes="114x114" href="img/favicons/114x114.png">
		
		<!-- CSS -->
		<link rel="stylesheet" href="css/reset.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css?family=Raleway:300|Muli:300" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="css/idangerous.swiper.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/ticker.css">
		
		<!-- Scripts -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	</head>
	<body>
		<div id="overlay"></div>
		<div id="top">
			<a href="#" id="sidebar-button"></a>
			<header id="logo">
				<img src="img/logo.png" alt="Logo">
			</header>
		</div>
		<div id="main-wrapper">
			<?php require_once("boloTicker.php"); ?>
			<div id="content">
				<div class="container-fluid">
					<div id="heading" class="row">
						<div class="col-12">
							<header>
								<h1>All Active Warrants</h1>
							</header>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<article class="inner">
								<div class="row">
									<div class="col-12">
										<h4>Total Active Warrants - <?php echo $acnt;?></h4>
									</div>
								</div>
									<center>
									<?php
										if($warrants){
							  		?>
									<table style="text-align: center">
								  	<tbody>
									<tr>
										<th>Name</th>
										<th>Approving Judge</th>
										<th>Crimes</th>
										<th>Type</th>
										<th>Date</th>
										<th>Link</th>
									</tr>
									<?php
									for($i = 0; $i < $acnt; $i++) {
										$cname = getCiv($warrants[$i]['uid'], U_ID);
										$exid = $warrants[$i]['id'];
										echo "
										<tr><td style=\"width:15%\"\>".antiXSS($cname['name'])."</td><td style=\"width:15%\">".antiXSS($warrants[$i]['dojname'])."</td><td style=\"width:30%\">".titleFormat(antiXSS($warrants[$i]['crimes']))."</td><td style=\"width:10%\">".antiXSS($warrants[$i]['wtype'])."</td><td style=\"width:10%\">".antiXSS($warrants[$i]['date'])."</td><td style=\"width:10%\">".("<a href=".$warrants[$i]['wlink']." target=\"_blank\">WARRANT LINK</a>")."</td></tr>";
									}
									?>
								  </tbody>
								  </table>
								  <?php } else echo "There are currently no active warrants!"; ?>
								</center>
							</article>
						</div>
					</div>
				</div>
			</div>
			<?php require_once("sidebar.php"); ?>
				<footer>
					<p class="copyright">&copy; Copyright 2017 <a href="http://coltonbrister.com" target="_blank">Colton Brister</a></p>
				</footer>
			</div>
		</div>

		<!-- JavaScripts -->
		<script type='text/javascript' src='js/jquery.min.js'></script>
		<script type='text/javascript' src='js/bootstrap.min.js'></script>
		<script type='text/javascript' src='js/swiper/idangerous.swiper.min.js'></script>
		<script type='text/javascript' src='js/masonry/masonry.pkgd.min.js'></script>
		<script type='text/javascript' src='js/isotope/jquery.isotope.min.js'></script>
		<script type='text/javascript' src='js/custom.js'></script>
		<script type="text/javascript" src="js/ticker.js"></script>

	</body>
</html>