<?php

$apikey = isset($_REQUEST['apikey']) ? $_REQUEST['apikey'] : "";
$appid = isset($_REQUEST['appid']) ? $_REQUEST['appid'] : "";
$description = isset($_REQUEST['description']) ? $_REQUEST['description'] : "";
$changelog = isset($_REQUEST['changelog']) ? $_REQUEST['changelog'] : "";
$user = isset($_REQUEST['user']) ? $_REQUEST['user'] : "";
$revision = isset($_REQUEST['revision']) ? $_REQUEST['revision'] : "";
$showform = false;
$errors = false;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	if(
		$_POST['user'] != "" && 
		$_POST['appid'] != "" && 
		$_POST['apikey'] != "" && 
		$_POST['description'] != "" && 
		$_POST['changelog'] != "" && 
		$_POST['revision'] != ""
	) {
        $url = "http://rpm.newrelic.com/deployments.xml";
        $data = array(
                'deployment[application_id]' => $appid,
                'deployment[description]' => $description,
                'deployment[changelog]' => $changelog,
                'deployment[user]' => $user,
                'deployment[revision]' => $revision,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-api-key:'.$apikey));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        if(!$output) { 
			echo curl_error($ch); 
		} else {
			echo var_dump($output);
		}
        curl_close($ch);
        
	} else {
		$errors = true;
		$showform = true;
	}
} else {
	$showform = true;
}

if($showform) {
?>
<!DOCTYPE html>
<html>
  <head>
    <title>New Relic Deployments</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
  </head>
  <body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>New Relic Deployment</h1>
				<p>Use this form to submit deployments or other events to New Relic.</p>
				<?php if($errors) { ?>
				<div class="alert alert-danger">Please correct the fields below, all fields are mandatory.</div>
				<?php } ?>
				<form method="post">
				  <div class="form-group <?php echo $errors && $apikey=="" ? "has-error" : ""; ?>">
					<label class="control-label" for="apikey">API Key</label>
					<input type="text" name="apikey" class="form-control" id="apikey" value="<?php echo $apikey; ?>">
					<p class="help-block">Example: zqnwv50o6680n11Br2t5Y3388rYPPHAr</p>
				  </div>
				  <div class="form-group <?php echo $errors && $appid=="" ? "has-error" : ""; ?>">
					<label class="control-label" for="appid">App ID</label>
					<input type="text" name="appid" class="form-control" id="appid" value="<?php echo $appid; ?>">
					<p class="help-block">Example: 1234567</p>
				  </div>
				  <div class="form-group <?php echo $errors && $description=="" ? "has-error" : ""; ?>">
					<label class="control-label" for="description">Description</label>
					<input type="text" name="description" class="form-control" id="description" value="<?php echo $description; ?>">
					<p class="help-block">Example: &quot;Release&quot;, &quot;Change&quot;, &quot;Start Load Test&quot;</p>
				  </div>
				  <div class="form-group <?php echo $errors && $changelog=="" ? "has-error" : ""; ?>">
					<label class="control-label" for="changelog">Changelog</label>
					<input type="text" name="changelog" class="form-control" id="changelog" value="<?php echo $changelog; ?>">
					<p class="help-block">Example: &quot;RFC14-32&quot;, &quot;RFC-1&quot;, &quot;JIRA-123&quot;</p>
				  </div>
				  <div class="form-group <?php echo $errors && $user=="" ? "has-error" : ""; ?>">
					<label class="control-label" for="user">User</label>
					<input type="text" name="user" class="form-control" id="user" value="<?php echo $user; ?>">
					<p class="help-block">Example: name@domain.com</p>
				  </div>
				  <div class="form-group <?php echo $errors && $revision=="" ? "has-error" : ""; ?>">
					<label class="control-label" for="revision">Revision</label>
					<input type="text" name="revision" class="form-control" id="revision" value="<?php echo $revision; ?>">
					<p class="help-block">Example: &quot;Build 1234&quot;, &quot;1.4.82&quot;</p>
				  </div>
				  <button type="submit" class="btn btn-primary">Submit</button>
				  <button type="reset" class="btn btn-default">Reset</button>
				</form>
			</div>
		</div>
	</div>
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
<?php } ?>