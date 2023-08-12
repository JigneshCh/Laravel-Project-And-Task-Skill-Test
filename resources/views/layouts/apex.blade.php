<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title','Home') | {{ config('app.name') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta content='text/html;charset=utf-8' http-equiv='content-type'>
        <meta content='Gesmansys' name='description'>
        @include('apex.include.cssfiles')
        @stack('css')
    </head>
    <body class="wrapper nav-collapsed">
        <div class="wrapper">
            @include('apex.include.topnav')
            <div class="main-panel">
                <div class="main-content">
                    <div class="content-wrapper">
                        @yield('content')
                        @include('apex.include.footer')
                    </div>
                </div>
            </div>
        </div>
    </body>

    @include('apex.include.jsfiles')
    @include('apex.include.page_notification')

	@stack('js')

	<script>
	function ajaxError(xhr, status, error) {
		if(xhr.status ==401){
			return "You are not logged in. please login and try again";
		}else if(xhr.status == 403){
			return "You have not permission for perform this operations";
		}else if(xhr.responseJSON && xhr.responseJSON.message!=""){
			return xhr.responseJSON.message;
		}else{
			return"Something went wrong , Please try again later.";
		}
	}
	</script>
</body>
</html>