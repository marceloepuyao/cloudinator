<?php
require_once('DB/db.php');
require_once('lib.php');

$lang = getLang();
$config = parse_ini_file(dirname(__FILE__)."/config.ini", true);
$catarray = getCategories();


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet"
	href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script
	src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
<style type="text/css" media="screen">
.jqm-content {
	padding-right: 25%;
	padding-left: 25%;
}
</style>
<title>Ingrese Empresa</title>
</head>
<body>

	<section id="nuevaempresa" data-role="page">
	<div data-role="header" data-theme="b">
		<a href="#" id="backbutton" data-icon="arrow-l"><?php echo get_string("back", $lang);?></a>
		<h1>Cloudinator</h1>
		
	</div>

	<div data-role="content" id="content" class="jqm-content ui-content">

		<CENTER>
			<p>
				<strong><?php echo get_string("addnewcompany", $lang);?></strong>
			</p>
		</CENTER>
		<div style="width: 100%; margin: 0 auto;">


			<ul data-role="listview" data-inset="true">
				<li data-role="fieldcontain"><label for="new-name-empresa"><?php echo get_string("namecompany", $lang);?>:</label> <input name="new-name-empresa" id="new-name-empresa"
					value="" data-clear-btn="true" type="text">
				</li>
				<li data-role="fieldcontain"><label for="industry"
					class="select"><?php echo get_string("industry", $lang);?>:</label> <select name="industry"
					id="industry">
						
						<?php foreach ($catarray as $cat){;?>
						<option value="<?php echo $cat?>"><?php echo get_string($cat, $lang);?></option>
						<?php }?>
						
				</select>
				</li>
				<li data-role="fieldcontain"><label for="textarea"><?php echo get_string("companyinformation", $lang);?>:</label> <textarea cols="40" rows="8" name="textarea"
						id="textarea"></textarea>
				</li>
				<li class="ui-body ui-body-b">
					<fieldset class="ui-grid-a">
						<div class="ui-block-a">
							<button id="cancel" data-theme="d"><?php echo get_string("cancel", $lang);?></button>
						</div>
						<div class="ui-block-b">
							<button id="btnNew" data-theme="b"><?php echo get_string("accept", $lang);?></button>
						</div>
					</fieldset>
				</li>
			</ul>

		</div>

	</div>
	</section>

	<script src="js/nuevaempresa.js" type="text/javascript"></script>
	<script type="text/javascript" src="http://webcursos.uai.cl/jira/s/es_ES-jovvqt-418945332/850/3/1.2.9/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=2ab5c7d9"></script> <!-- JIRA (para reportar errores)-->
	<style type="text/css">.atlwdg-trigger.atlwdg-RIGHT{background-color:red;top:70%;z-index:10001;}</style>
</body>
</html>