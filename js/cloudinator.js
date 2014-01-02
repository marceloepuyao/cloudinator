var nodos = new Array();
var links = new Array();
var movingnodename = "";


function getQueryStringByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
function noticeSaving(state){
	if(state == "success"){
		$('body').css('cursor', 'auto');

		$('#notice-savechanges-success').css('display', '');
		$('#notice-savechanges-inprogress').css('display', 'none');
		$('#notice-savechanges-error').css('display', 'none');
		//$('#notice-savechanges-warning').css('display','none');
	}else if(state == "inprogress"){
		$('body').css('cursor', 'wait');

		$('#notice-savechanges-success').css('display', 'none');
		$('#notice-savechanges-inprogress').css('display', '');
		$('#notice-savechanges-error').css('display', 'none');
		//$('#notice-savechanges-warning').css('display','none');
	}else if(state == "error"){
		$('body').css('cursor', 'auto');

		$('#notice-savechanges-success').css('display', 'none');
		$('#notice-savechanges-inprogress').css('display', 'none');
		$('#notice-savechanges-error').css('display', '');
		//$('#notice-savechanges-warning').css('display','');
	}else if(state == "warning"){
		$('body').css('cursor', 'auto');

		$('#notice-savechanges-success').css('display', 'none');
		$('#notice-savechanges-inprogress').css('display', 'none');
		$('#notice-savechanges-error').css('display', 'none');
		$('#notice-savechanges-warning').css('display','');
	}
	else if(state == "clear"){
		$('body').css('cursor', 'auto');

		$('#notice-savechanges-success').css('display', 'none');
		$('#notice-savechanges-inprogress').css('display', 'none');
		$('#notice-savechanges-error').css('display', 'none');
		//$('#notice-savechanges-warning').css('display','none');
	}

}
function noticeDeletedAndReleased(){
	$.ajax({
		url: 'ajax/ajaxTrees.php',
		dataType: 'json',
		type: 'POST',
		data: {
			action: 'checkReleasedAndDeleted',
			id: getQueryStringByName("id")
				},
		timeout: 2500,
		success: function(data){
			if(data.result){
				if(data.released == "1" && data.deleted == "1"){
					alert('Este Subformulario está "Publicado" y "Eliminado", por lo cual no se puede modificar.\n Cualquier cambio que haga no será guardado.');
				}else if (data.released == "1") {
					alert('Este Subformulario está "Publicado", por lo cual no se puede modificar.\n Cualquier cambio que haga no será guardado.');
				}else if (data.deleted == "1") {
					alert('Este Subformulario está "Eliminado", por lo cual no se puede modificar.\n Cualquier cambio que haga no será guardado.');
				}
			}else{
				alert('Se produjo un error al comprobar el estado del formulario.\nIntente nuevamente.');
			}
		}
	}).fail(function(jqXHR, textStatus, errorThrown) {
		if(textStatus==="timeout") {
			//window.location.reload();
		}else{
			console.log("fail", errorThrown, textStatus);
			console.log("fail", jqXHR);
		}
	});
}
AUI().use('aui-io-request', 'aui-diagram-builder', function(A){
	noticeDeletedAndReleased();
	A.one('.aui-diagram-builder-canvas').setStyle('background', 'white');
	A.one('#EditName').on('click', function(){
		
		cambianombre();
	});
	
	A.one('#deleteForm').on('click', function(){
		estaseguro();
	});
	
	A.one('#back').on('click', function(){
		A.io.request('ajax/ajaxMegaTrees.php', {
			cache: false,
			autoLoad: true,
			dataType: 'json',
			method: 'POST',
			data: {action:'whoIsTheFather',id:getQueryStringByName('id')},
			on: {
				success: function() {
					var response = this.get('responseData');
					if(response.result){
						window.location = "editor.php?id="+response.id;
					}else{
						console.log('exception',response.exception);
					}
				}
			}
		});
	});
	function cambianombre(){
		var newname = prompt("Nuevo Nombre","");
		if (newname!=null && newname!="" && newname.length>0){
			A.io.request('ajax/ajaxTrees.php', {
				dataType: 'json',
				method: 'POST',
				data: {
					tree: getQueryStringByName('id'),
					nuevonombre: newname
						},
				on: {   
					success: function() {
						var response = this.get('responseData');
						if(response.result){
							window.location = "cloudinator.php?id="+getQueryStringByName('id');
						}else if(response.exception == "NombreOcupado"){
							alert("Nombre Ocupado");
						}else{
							alert("No se pudo cambiar el nombre");
							console.log("error al cambiar el nombre", response.exception);
						}
					}
				}
			});
		}
	}
	function estaseguro(){
		if(confirm("¿Esta Seguro que deseas eliminar el subformulario?")){
			A.io.request('ajax/ajaxTrees.php', {
				dataType: 'json',
				method: 'POST',
				data: {
					tree: getQueryStringByName('id'),
					action: "deleteTree"
						},
				on: {   
					success: function(data) {
						console.log(data);
						window.location = "editor.php";
					}
				}
			});
				
		}else{
			
		}
		
	}
	
	A.io.request('ajax/ajaxnodos.php', {
		cache: false,
		autoLoad: true,
		dataType: 'json',
		method: 'POST',
		data: {tree: getQueryStringByName('id')},
		on: {   
			start:function(){
				//mostrar loading
			},
			success: function() {					
				var datos = this.get('responseData');
				for (var i=0; i < datos.length; i++) {
		   			nodos[i] = datos[i];
	   			} 
				cargaNodos();
			}
		}
	});
	
	function andaABuscarLosLinks(treeID) {
		A.io.request('ajax/ajaxlinks.php', {
			dataType: 'json',
			method: 'POST',
			data: {tree: treeID},
			on: {
				success: function() {
					var response = this.get('responseData');
					if(response.result){
						for (var i=0; i < response.datos.length; i++) {
				   			links[i] = response.datos[i];
			   			} 
						cargaLinks();
					}else{
						console.log('andaABuscarLosLinks-exception',response.exception);
						alert('Error al cargar los links, refresque la página.');
					}					
				},
				failure: function(){
					alert('Error al cargar los links, refresque la página.');
				}
			}
		});
	}
	function ajaxPostNodo(action, name, type, posx, posy, tree, id){
		A.io.request('ajax/ajaxpost.php', {
			autoLoad: true,
			method: 'POST',
			dataType: 'json',
			data: {
				nodo: action,
				name: name,
				tree: tree,
				type: type,
				posx: posx,
				posy: posy,
				id: id
			},
			on: {
				success: function(data){
					console.log('ajaxPostNodo', this.get('responseData'));
					if(this.get('responseData').result){
						noticeSaving('success');
					}else{
						noticeSaving('error');
					}
					deleltelinesinfo();
				},
				failure: function(data){
					noticeSaving('warning');
				},
				start: function(){
					noticeSaving('inprogress');
					console.log('borrar', action);
				}
			}
		});
	}
	function ajaxUpdateMetadata(nombre, tree, metaname, metadata, metatype){
		A.io.request('ajax/ajaxpost.php', {
			autoLoad: true,
			method: 'POST',
			dataType: 'json',
			data: {
				nodo: 'updateMeta',
				newname: newname,
				oldname: oldname,
				tree: tree
			},
			on: {
				success: function(data){
					console.log('AJAXresponseData',this.get('responseData'));
					noticeSaving('success');
				},
				failure: function(data){
					noticeSaving('warning');
				},
				start: function(){
					noticeSaving('inprogress');
				}
			}
		});
	}
	function ajaxChangeNodoNameTEST(oldname, newname, tree){
		A.io.request('ajax/ajaxpost.php', {
			autoLoad: true,
			method: 'POST',
			dataType: 'json',
			data: {
				nodo: 'newnameTEST',
				newname: newname,
				oldname: oldname,
				tree: tree
			},
			on: {
				success: function(data){
					console.log('AJAXresponseData', responseResult);
					noticeSaving('success');
				},
				failure: function(data){
					noticeSaving('warning');
				},
				start: function(){
					noticeSaving('inprogress');
				}
			}
		});
	}

	function ajaxChangeNodoName(id, newname, tree){
		A.io.request('ajax/ajaxpost.php', {
			autoLoad: true,
			method: 'POST',
			dataType: 'json',
			data: {
				nodo: 'newname',
				name: newname,
				id: id,
				tree: tree
			},
			on: {
				success: function(data){
					console.log('AJAXresponseData',this.get('responseData'));
					noticeSaving('success');
				},
				failure: function(data){
					noticeSaving('warning');
				},
				start: function(){
					noticeSaving('inprogress');
				}
			}
		});
	}

	function ajaxNodoGetIdFromName(name, tree){
		A.io.request('ajax/ajaxpost.php', {
			autoLoad: true,
			method: 'POST',
			dataType: 'json',
			data: {
				getIdFromName: name,
				tree: tree
			},
			on: {
				success: function(data){
					console.log('AJAXresponseData', this.get('responseData'));
					return this.get('responseData');
				}
			}
		});
	}
	
	function ajaxFormNamebyId(idForm){
		A.io.request('ajax/ajaxpost.php', {
			autoLoad: true,
			method: 'POST',
			dataType: 'json',
			data: {
				formId: idForm,
			},
			on: {
				success: function(data){
					A.one('#SubFormName').text('Subformulario: ' + this.get('responseData'));
					//return this.get('responseData');
				}
			}
		});
	}

	function ajaxPostLink(action, name, source, target, tree){
		A.io.request('ajax/ajaxpost.php', {
			autoLoad: true,
			method: 'POST',
			dataType: 'json',
			data: {
				link: action,
				name: name,
				tree: tree,
				source: source,
				target: target
			},
			on: {
				success: function(data){
					noticeSaving('success');
				},
				failure: function(data){
					noticeSaving('warning');
				},
				start: function(){
					noticeSaving('inprogress');
				}
			}
		});
	}

	//var typestart = 'start';
	var typeend = 'end';
	var typepregunta = 'condition';
	var typerespuesta = 'state';
	var availableFields = [
		{
			type: typerespuesta,
			label: 'Respuesta',
			iconClass: 'aui-diagram-node-state-icon'
		},
		{
			type: typepregunta,
			label: 'Pregunta',
			iconClass: 'aui-diagram-node-condition-icon'
		},
		{
			type: typeend,
			label: 'Fin',
			iconClass: 'aui-diagram-node-end-icon'
		}
		
	];

	function cargaNodos() {
		
		var field = new Array();
		for (var i=0; i < nodos.length; i++) {
			var x = {};
			x.idnode = nodos[i].id;
			x.name = nodos[i].name;
			x.type = nodos[i].type;
			x.xy = [parseInt(nodos[i].posx), parseInt(nodos[i].posy)];
			x.description =  '';
			x.metadata = nodos[i].metadata;
			x.metatype = nodos[i].metatype;
			x.metaname = nodos[i].metaname;
			field.push(x);
		} 

		console.log('nodos', nodos[1]);
		db1 = new A.DiagramBuilder(
			{
				availableFields: availableFields,
				useARIA: true,
				boundingBox: '#diagrambuilderBB',
				srcNode: '#diagrambuilderCB',
				on: {
					 '*:drag': function(event) {
						
							
					},
					'*:end': function(event){
						var drag = event.target;
						var diagramNode = A.Widget.getByNode(drag.get('dragNode'));
						console.log("end", diagramNode);
						if(diagramNode!= null){
							var nodeid = diagramNode.get('idnode');
							var type = diagramNode.get('type');
							var name = diagramNode.get('name');
							
							var containerXY = this.dropContainer.getXY();
							
							var posix = event.pageX - containerXY[0];
							var posiy = event.pageY - containerXY[1];
							
							if(posix < 0 || posiy < 0){
								//error message or simply do nothing
							}else if(nodeid != undefined && nodeid != "" && nodeid != null){
								ajaxPostNodo('update', name, type, posix, posiy, getQueryStringByName('id'), nodeid); //event.pageX no es la posicion exacta, porque considera todo
							}
						}
						
					},
					'*:hit': function(event){
						
			
						var lastXY = event.drag.lastXY;
						var containerXY = this.dropContainer.getXY();
						
						var posix = lastXY[0] - containerXY[0];
						var posiy = lastXY[1] - containerXY[1];
						
						if(posix<0 || posiy< 0){
							alert("No se puede crear nodos fuera del área de trabajo");
							window.location = "";
						}
						
						var instance = this;
						var drag = event.drag;

						if (instance.isAvailableFieldsDrag(drag)) {
							var availableField = drag.get('node').getData('availableField');
							
							var nodetype = availableField.get("type");
							
							var nombre = "nuevonombre " + parseInt(Math.random()*10000) ;

							if(posix < 0 || posiy < 0){
								//error message or simply do nothing
							}else if(nodetype == "state" || nodetype == "condition" || nodetype == "end" ){
								ajaxPostNodo('insert', nombre, nodetype, posix, posiy, getQueryStringByName('id'), null);
							}
							console.log("hit");
							
							var newField = instance.addField({
								xy: [posix, posiy] ,
								type: nodetype,
								name: nombre
							});

							//instance.select(newField);
							deleltelinesinfo();
							
						}
						//A.one('#savechanges').setStyle('display', '');
						deleltelinesinfo();
					},
					save: function(event) {
						//aca se guardan los cambios
						console.log('save', event.target.editingNode.get('name'));
						//A.one('#savechanges').setStyle('display', '');
					}
				},

				fields: field,
				render: true
			}
		);
		console.log('db1',A.one('.aui-diagram-builder-drop-container.yui3-dd-drop').siblings('div').item(1).setStyle('top', '25'));
		
		andaABuscarLosLinks(getQueryStringByName('id'));
	}
	// db1.syncTargetsUI();

	// var task2 = db1.addField({
	// 	name: 'Task2',
	// 	type: 'condition'
	// });

	// task2.addTransition('Task1');
	// task2.connect('Task1');
	
	function cargaLinks() {
		
		var connectors = new Array();
		for (var i=0; i < links.length; i++) {
			var x = {};
			x.connector = {};
			x.connector.name = links[i].name;
			
			for(var j=0; j < nodos.length; j++) {
				if(nodos[j].id == links[i].source){
					x.source = nodos[j].name;
				}else if(nodos[j].id == links[i].target){
					x.target = nodos[j].name;
				}
			}
			connectors.push(x);
		} 
		
		db1.connectAll(connectors);
		
		createmetadatatable();
		deleltelinesinfo();
		ajaxFormNamebyId(getQueryStringByName('id'));
	}
	
	function deleltelinesinfo(){
		var a = A.all('.aui-diagram-builder-connector-name');
		//db1.connector.hide();
		a.remove();
	}

	
	function createmetadatatable(){
		
		
	}

	
});
