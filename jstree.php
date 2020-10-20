<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>jstree basic demos</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
</head>
<body>

	<h1>Basic Select data With Php MySQL</h1>
	
	<div id="frmt"></div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
	
	<script>
    

	$('#frmt').jstree({
        "checkbox" : {
      "keep_selected_style" : false
    },
    "plugins" : [ "checkbox" ]
  });
		"state" : { "key" : "demo" },
		"check_callback" : true,
		'core' : {
			'data' : {
				"url" : "respone.php",
				"dataType" : "json" // needed only if you do not supply JSON headers
			}
		}
	});
	
	</script>
</body>
</html>