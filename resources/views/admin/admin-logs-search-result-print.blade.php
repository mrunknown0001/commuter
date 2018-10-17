
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Logs Search Result Print</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"><!-- 
  <link rel="stylesheet"  href="{{ asset('adminlte/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/css/skins/skin-blue-light.min.css') }}"> -->
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="{{ asset('js/app.js') }}"></script>
  <style type="text/css">
    .vertical-center {
      margin-top: 100px !important;
    }
  </style>
</head>
<body>
	<div class="content-wrapper">
		<section class="content">
			<div class="row">
				<div class="col-md-12">
        @if(count($logs) > 0)
        <table class="table table-hover">
          <thead>
            <tr>
              <th>User</th>
              <th>Action</th>
              <th>Time &amp; Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($logs as $log)
            <tr>
              <td>
                {{ ucwords($log->first_name) }}
                {{ ucwords($log->last_name) }}
              </td>
              <td>
                {{ $log->action_performed }}
              </td>
              <td>
                {{ date('l, F j, Y g:i:s a', strtotime($log->performed_on)) }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <p class="text-center"><em>No Admin Logs</em></p>
        @endif
				</div>
			</div>
		</section>
	</div>
<script type="text/javascript">
	$( document ).ready(function() {
	    window.print();
	});
</script>
</body>
</html>


