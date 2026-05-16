		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Dashboard | {{ $settings->admin_title ?? 'Next Digi Home - Premium Digital Products Marketplace' }}</title>
	@if(!empty($settings->favicon))
		<link rel="shortcut icon" type="image/png" href="{{ asset('public/admin_resource/assets/images/'.$settings->favicon) }}">
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/admin_resource/assets/images/'.$settings->favicon) }}">
	@else
		<link rel="shortcut icon" type="image/png" href="{{ asset('favicon.ico') }}">
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
	@endif
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="@if(!empty($settings->admin_description)) @endif">
		<meta name="author" content="Imran Rahman">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{ asset('public/admin_resource/')}}/assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
		<link rel="stylesheet" href="{{ asset('public/admin_resource/')}}/assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="{{ asset('public/admin_resource/')}}/assets/vendor/select2/select2.css" />
		<link rel="stylesheet" href="{{ asset('public/admin_resource/')}}/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
		<link rel="stylesheet" href="{{ asset('public/admin_resource/')}}/assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="{{ asset('public/admin_resource/')}}/assets/vendor/morris/morris.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{ asset('public/admin_resource/')}}/assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="{{ asset('public/admin_resource/')}}/assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{ asset('public/admin_resource/')}}/assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="{{ asset('public/admin_resource/')}}/assets/vendor/modernizr/modernizr.js"></script>
		<script src="{{ asset('public/admin_resource/assets/vendor/jquery/jquery.js') }}"></script>
		<script src="{{ asset('public/admin_resource/assets/vendor/bootstrap/js/bootstrap.js') }}"></script>
		<!-- Note: jQuery Validation removed - using custom validation instead -->
		
		<!-- Select2 JS -->
		<script src="{{ asset('public/admin_resource/')}}/assets/vendor/select2/select2.js"></script>
		
     <!-- Flag Icons -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icons/6.6.6/css/flag-icons.min.css">
   
    	<style>
	  	.logo {
	  		height: 100px !important;
	  		display: flex !important;
	  		align-items: center !important;
	  		justify-content: center !important;
	  		margin-top: -18px !important;
	  	}
	  	
	  	.logo img {
	  		max-height: 90px !important;
	  		max-width: 250px !important;
	  		width: auto !important;
	  		height: auto !important;
	  		object-fit: contain !important;
	  		display: block !important;
	  	}
		 /* Language Switcher Styles */
        .language-flag {
            width: 20px;
            height: 15px;
            border-radius: 2px;
            margin-right: 8px;
        }
        
        .language-dropdown {
            display: inline-block;
        }
        
        .language-dropdown .dropdown-menu {
            min-width: 200px;
            z-index: 1000;
        }
        
        .language-item {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            transition: all 0.3s;
        }
        
        .language-item:hover {
            background-color: #f8f9fa;
        }
        
        .language-item.active {
            background-color: #e9ecef;
            font-weight: bold;
        }
		  .text-start { text-align: right !important; }
        .text-end { text-align: left !important; }
    	</style>
         
    <meta name="csrf-token" content="{{ csrf_token() }}">
