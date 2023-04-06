<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="apple-touch-icon" type="image/png" href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png">
	<meta name="apple-mobile-web-app-title" content="CodePen">
	<link rel="shortcut icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico">
	<link rel="mask-icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111">
	<title><?= $data['errorCode'] ?></title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arvo">
	<style>
		/*======================
    404 page
=======================*/
		.page_404 {
			padding: 40px 0;
			background: #fff;
			font-family: 'Arvo', serif;
		}
		.page_404 img {
			width: 100%;
		}
		.four_zero_four_bg {
			background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
			height: 400px;
			background-position: center;
		}
		.four_zero_four_bg h1 {
			font-size: 80px;
		}
		.four_zero_four_bg h3 {
			font-size: 80px;
		}
		.link_404 {
			color: #fff !important;
			padding: 10px 20px;
			background: #39ac31;
			margin: 20px 0;
			display: inline-block;
		}
		.contant_box_404 {
			margin-top: -50px;
		}
	</style>
	<script>
		window.console = window.console || function(t) {};
	</script>
	<script>
		if (document.location.search.match(/type=embed/gi)) {
			window.parent.postMessage("resize", "*");
		}
	</script>
</head>
<body translate="no">
	<section class="page_404">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 ">
					<div class="col-sm-10 col-sm-offset-1  text-center">
						<div class="four_zero_four_bg">
							<h1 class="text-center "><?= $data['errorCode'] ?></h1>
						</div>
						<div class="contant_box_404">
							<h3 class="h2">
								<?= $data['errorMessage'] ?>
							</h3>
							<p>the page you are looking for not avaible!</p>
							<a href="" class="link_404">Go to Home</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>




