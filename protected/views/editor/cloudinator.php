<?php



?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/alloy-1.7.0/build/aui/aui.js" type="text/javascript"></script>

	<link rel='stylesheet' href='<?php echo Yii::app()->request->baseUrl;?>/assets/alloy-1.7.0/build/aui-skin-classic/css/aui-skin-classic-all-min.css' type='text/css' media='screen' />

	<style type="text/css" media="screen">
		.aui-diagram-builder-tabs{
			position: fixed;
			left: 0px;
			top: 120px;
			background-color: inherit;
			border-color: #CCCCCC;
			border-width: 1px;
			border-style: solid;
			z-index: 101;
		}
		.aui-diagram-builder-content-container{
			height: 1000px;
			padding-top: 90px;
		}
		.aui-diagram-node, .aui-basecelleditor {
			z-index: 1000 !important;
		}
		.aui-diagram-builder-connector-wrapper {
			z-index: 1;
		}
		.log {
			white-space: nowrap;
			font-size: 10px;
		}
		.aui-diagram-builder-canvas{
			width: 3500px;
			height: 1000px;
			background:white;

		}
		.header{
			background-image: url("http://www.sonda.com/media/media2011/img/fondo-new.jpg");
			background-repeat: repeat-x;
			height: auto;
			min-height: 90px;
			width: 100%;
		}
		.bg_top {
			background: url("http://www.sonda.com/media/media2011/img/fondo-header.jpg") repeat-x scroll 0;
			width: 100%;
			height: auto;
			position: fixed;
			right: 0;
			top: 0;
			z-index: 1001;
			overflow: hidden;
			min-width: 1024px;
		}
		.notification-icon{
			top: 4px;
			position: relative;
		}
		#EditForm{
			position: fixed;
			left: 0px;
			z-index: 1001;
		}
	</style>
</head>

<body class='yui3-skin-sam'>

<div class="bg_top">
		<div class='header'>
			<a href="<?php echo Yii::app()->request->baseUrl;?>/editor/index"><img src="../../images/logo-sonda-white.png" height=60px border=0px></a>
		</div>
	</div>
<div id="wrapper">

	<div id="demo">

		<div id="diagrambuilderBB" class="aui-diagram-builder">
			<div id="diagrambuilderCB" class="aui-helper-clearfix aui-diagram-builder-content">

				<div class="aui-diagram-builder-tabs">
					<div class="aui-diagram-builder-tabs-content">
						<ul class="aui-tabview-list aui-widget-hd">
							<li class="aui-tab aui-state-default aui-state-active aui-tab-active aui-diagram-builder-tab-add">
								<span class="aui-tab-content"><a class="aui-tab-label" href="javascript:;">Add node</a></span>
							</li>
							<li class="aui-tab aui-state-default aui-diagram-builder-tab-settings">
								<span class="aui-tab-content"><a class="aui-tab-label" href="javascript:;">Settings</a></span>
							</li>
						</ul>

						<div class="aui-tabview-content aui-widget-bd">
							<div class="aui-tabview-content-item"></div>
							<div class="aui-tabview-content-item aui-helper-hidden"></div>
						</div>
					</div>
				</div>

				<div class="aui-diagram-builder-content-container" >
					<div class="aui-diagram-builder-canvas">
						<div id="EditForm" class="aui-tabview-list aui-widget-hd" style="height: 25px;">
							<span>
								<strong id="SubFormName"><?php echo "Subformulario: ".$subformulario->name;?></strong>
							</span>
							<span style="cursor:pointer">
								<a href="<?php echo Yii::app()->request->baseUrl."/editor/subforms/".$subformulario->megatree;?>" class="aui-tab-label">Volver</a>
							</span>
							<a href=#><span id="help" style ="font-style: italic;"><img src="../../images/help_icon.png" class = "notification-icon">
							</span></a>
							<span id="notice-savechanges-success" style = "display: none; font-weight: bold;"><img src="../../images/success.png" class = "notification-icon"> Guardado.</span>
							<span id="notice-savechanges-inprogress" style ="display: none; font-style: italic;"><img src="../../images/wait.gif" class = "notification-icon"> Guardando.</span>
							<span id="notice-savechanges-error" style ="display: none; font-weight: bold; font-style: italic;"><img src="../../images/error.png" class = "notification-icon"> No Guardado.</span>
							<span id="notice-savechanges-warning" style ="display: none; font-weight: bold; font-style: italic;"><img src="../../images/warning.png" class = "notification-icon"> ¡Se perdió la conección con el servidor!</span>				
							
						</div>
						<div class="aui-diagram-builder-drop-container" >
						</div>
					</div>
				</div>

			</div>
		</div>

		<br/>
		<br/>
		<br/>

		<div id="diagramBuilder2"></div>

	</div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/js/cloudinator.js" type="text/javascript"></script>
<script type="text/javascript" src="http://webcursos.uai.cl/jira/s/es_ES-jovvqt-418945332/850/3/1.2.9/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=2ab5c7d9"></script>
<style type="text/css">.atlwdg-trigger.atlwdg-RIGHT{background-color:red;top:70%;z-index:10001;}</style>

</body>
</html>