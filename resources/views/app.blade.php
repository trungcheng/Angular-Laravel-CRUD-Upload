<!DOCTYPE html>
<html lang="en" ng-app="TestApp">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TestApp</title>
	<link rel="stylesheet" href="{{ asset('app/library/bootstrap.min.css') }}">
	<!-- <script src="{{ asset('app/packages/dirPagination.js') }}"></script> -->
	<!--<script src="{{ asset('app/services/myServices.js') }}"></script>
	<script src="{{ asset('app/helper/myHelper.js') }}"></script> -->
	<style>
		.login-form input.ng-invalid.ng-touched{
		  	border-color: #f00;
		}
		.login-form input.ng-valid.ng-touched{
		  	border-color: none;
		}
		.error{
		  	color:#f00;
		  	padding-left:15px;
		  	padding-top: 5px;
		}
		.sortorder:after {
		  	content: '\25b2';   // BLACK UP-POINTING TRIANGLE
		}
		.sortorder.reverse:after {
		  	content: '\25bc';   // BLACK DOWN-POINTING TRIANGLE
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#/products">TestApp</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="#/products">Home</a></li>
					<li><a href="#/products">About</a></li>
					<li><a href="#/products">Contact</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<div ui-view=""></div>
	</div>

	<!-- Scripts -->
	<script src="{{ asset('app/library/jquery.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('app/library/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('app/library/angular.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('app/library/angular-ui-router.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('app/routes.js') }}" type="text/javascript"></script>
	<script src="{{ asset('app/directives.js') }}" type="text/javascript"></script>
	<script src="{{ asset('/app/controllers/MemberController.js') }}" type="text/javascript"></script>

</body>
</html>
