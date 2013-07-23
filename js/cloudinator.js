var nodos = new Array();
var links = new Array();
var movingnodename = "";
function getQueryStringByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

AUI().use('aui-io-request', 'aui-diagram-builder', function(A){

	A.io.request('ajaxnodos.php', {
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
					//var id = datos[i].id;
					//console.log("iddd", id);
		   			nodos[i] = datos[i];
	   			} 
				cargaNodos();
				
			}
		}
	});

	function andaABuscarLosLinks(treeID) {
		A.io.request('ajaxlinks.php', {
			dataType: 'json',
			method: 'POST',
			data: {tree: treeID},
			on: {   
				success: function() {
					var datos = this.get('responseData');
					for (var i=0; i < datos.length; i++) {
			   			links[i] = datos[i];
		   			} 
					cargaLinks();
				}
			}
		});
	}
	function ajaxPostNodo(action, name, type, posx, posy, tree){
		A.io.request('ajaxpost.php', {
			autoLoad: true,
			method: 'POST',
			data: {
				nodo: action,
				name: name,
				tree: tree,
				type: type,
				posx: posx,
				posy: posy
			},
			on: {
				success: function(data){
					console.log('AJAXresponseData',this.get('responseData'));
					//console.log('AJAX',data);
				}
			}
		});
	}
	function ajaxUpdateMetadata(nombre, tree, metaname, metadata, metatype){
		A.io.request('ajaxpost.php', {
			autoLoad: true,
			method: 'POST',
			data: {
				nodo: 'updateMeta',
				newname: newname,
				oldname: oldname,
				tree: tree
			},
			on: {
				success: function(data){
					console.log('AJAXresponseData',this.get('responseData'));
					//console.log('AJAX',data);
				}
			}
		});
	}
	function ajaxChangeNodoNameTEST(oldname, newname, tree){
		A.io.request('ajaxpost.php', {
			autoLoad: true,
			method: 'POST',
			data: {
				nodo: 'newnameTEST',
				newname: newname,
				oldname: oldname,
				tree: tree
			},
			on: {
				success: function(data){
					console.log('AJAXresponseData',this.get('responseData'));
					//console.log('AJAX',data);
				}
			}
		});
	}

	function ajaxChangeNodoName(id, newname, tree){
		A.io.request('ajaxpost.php', {
			autoLoad: true,
			method: 'POST',
			data: {
				nodo: 'newname',
				name: newname,
				id: id,
				tree: tree
			},
			on: {
				success: function(data){
					console.log('AJAXresponseData',this.get('responseData'));
					//console.log('AJAX',data);
				}
			}
		});
	}

	function ajaxNodoGetIdFromName(name, tree){
		A.io.request('ajaxpost.php', {
			autoLoad: true,
			method: 'POST',
			data: {
				getIdFromName: name,
				tree: tree
			},
			on: {
				success: function(data){
					console.log('AJAXresponseData', this.get('responseData'));
					//console.log('AJAX',data);
					return this.get('responseData');
				}
			}
		});
	}

	function ajaxPostLink(action, name, source, target, tree){
		A.io.request('ajaxpost.php', {
			autoLoad: true,
			method: 'POST',
			data: {
				link: action,
				name: name,
				tree: tree,
				source: source,
				target: target
			},
			on: {
				success: function(data){
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
		//console.log("field", nodos);
		for (var i=0; i < nodos.length; i++) {
			var x = {};
			x.name = nodos[i].name;
			x.type = nodos[i].type;
			x.xy = [parseInt(nodos[i].posx), parseInt(nodos[i].posy)];
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
						 
						var drag = event.target;
						var idnode = drag.get('node').getAttribute("id");
						
						if(drag.get('node').getAttribute("title") == "Pregunta"){
							movingnodename= "" ;
						}else if(drag.get('node').getAttribute("title")== "Respuesta"){
							movingnodename= "";
						}else if(drag.get('node').getAttribute("title")== "Fin"){
							movingnodename= "";
						}else{
							movingnodename = A.one('#'+idnode).get('children').slice(-2).get('text')[0];
						}
							
						deleltelinesinfo();
					},
					'*:end': function(event){
						
						var containerXY = this.dropContainer.getXY();
						
						var posix = event.pageX - containerXY[0];
						var posiy = event.pageY - containerXY[1];
						
						if(posix < 0 || posiy < 0){
							//error message or simply do nothing
						}else if(movingnodename != ""){
							ajaxPostNodo('update', movingnodename, 'condition', posix, posiy, getQueryStringByName('id')); //event.pageX no es la posicion exacta, porque concidera todo
						}
						
						deleltelinesinfo();
					},
					'*:hit': function(event){
						console.log("nueva pregunta: ", event.drag.get('node')); 
						//console.log("hit drag", event.drag.get('node').getData);
						
						var lastXY = event.drag.lastXY;
						var containerXY = this.dropContainer.getXY();
						
						var posix = lastXY[0] - containerXY[0];
						var posiy = lastXY[1]- containerXY[1];
						
						var instance = this;
						var drag = event.drag;

						if (instance.isAvailableFieldsDrag(drag)) {
							var availableField = drag.get('node').getData('availableField');
							
							var nodetype = availableField.get("type");
							
							var nombre = "nuevonombre " + parseInt(Math.random()*10000) ;

							if(posix < 0 || posiy < 0){
								//error message or simply do nothing
							}else if(nodetype == "state" || nodetype == "condition" || nodetype == "end" ){
								ajaxPostNodo('insert', nombre, nodetype, posix, posiy, getQueryStringByName('id'));
							}else if(nodetype == "start"){
								
								
							}
							
							var newField = instance.addField({
								xy: [posix, posiy] ,
								type: nodetype,
								name: nombre
							});

							//instance.select(newField);
							
							
						}
						deleltelinesinfo();
					},
					save: function(event) {
						//aca se guardan los cambios
						console.log('save', event.target);
					}
				},

				fields: field,
				render: true
			}
		);
		//console.log('db1',db1);
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
	}
	
	function deleltelinesinfo(){
		var a = A.all('.aui-diagram-builder-connector-name');
		//db1.connector.hide();
		a.remove();
	}

	
	function createmetadatatable(){
		console.log("aasasdsa",db1);
	}
	
});