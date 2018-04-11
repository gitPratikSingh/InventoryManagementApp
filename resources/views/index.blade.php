<!DOCTYPE html><!-- Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4Author: KeenThemesWebsite: http://www.keenthemes.com/Contact: support@keenthemes.comFollow: www.twitter.com/keenthemesDribbble: www.dribbble.com/keenthemesLike: www.facebook.com/keenthemesPurchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemesRenew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemesLicense: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.-->
<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>
			Metronic | Dashboard
		</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			          WebFont.load({            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},            active: function() {                sessionStorage.fonts = true;            }          });        


		</script>
		<!--end::Web font -->        <!--begin::Base Styles -->                           <!--begin::Page Vendors -->
		
		<link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />

	</head>
	<!-- end::Head -->        <!-- end::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<!--[html-partial:include:{"file":"_layout.html"}]/-->
        @include('_layout')

    	<!--begin::Base Scripts -->
		<script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
		<!--end::Base Scripts -->                   
		<script src="{{ asset('assets/demo/default/custom/components/datatables/scrolling/both.js') }}" type="text/javascript"></script>
		<script src="{{ asset('assets/demo/default/custom/components/forms/widgets/bootstrap-switch.js') }}" type="text/javascript"></script>
	</body>
	<!-- end::Body -->
</html>
