AUI().use('aui-diagram-builder', 'aui-io-request', function(A) {
	var nodes = Array();
	var nodos = Array();
	//A.one('#informacion').hide();
	A.io.request('ajaxnodos.php', {
		cache: false,
		autoLoad: true,
		dataType: 'json',   on: {   
			success: function() {					
				var datos = this.get('responseData');
				for (var i=0; i < datos.length; i++) {
		   			nodos[i] = datos[i];
		   			/*
		   			A.one('#informacion').append('<div id=id'+i+'></div>');
		   			A.one('#id'+i).append('<div id=name>'+nodos[i].name+'</div>');
		   			A.one('#id'+i).append('<div id=type>'+nodos[i].type+'</div>');
		   			A.one('#id'+i).append('<div id=posx>'+nodos[i].posx+'</div>');
		   			A.one('#id'+i).append('<div id=posy>'+nodos[i].posy+'</div>');
		   			*/
	   			}
	   			console.log('recien sacado', nodos[0].name);
			}
		}
	});
	A.io.request('ajaxlinks.php', {
		dataType: 'json',   on: {   
			success: function() {
				var links = Array();
				var datos = this.get('responseData');
				for (var i=0; i < datos.length; i++) {
		   			links[i] = datos[i];
	   			} 
			}
		}
	});
	A.io.request('ajaxpost.php', {
		autoLoad: true,
		method: 'POST',
		data: {
			nodo: 'add',
			name: 'nueva pregunta',
			type: 'condition',
			posx: 1,
			posy: 1
	   	},
	   	on: {
	   		success: function(data){
	   			if(data){
	   				console.log("AJAX", data);
	   			}
	   		}
	   	}
	});

	A.io.request('ajaxpost.php', {
		autoLoad: true,
		method: 'POST',
		data: {
			link: 'add',
			name: '',
			source: 1,
			target: 2
		},
		on: {
			success: function(data){
				if(data){
					console.log("AJAX", data);
				}
			}
		}
	});

	var typepregunta = 'condition';
	var typerespuesta = 'end';
	var availableFields = [
		{
			type: 'end',
			label: 'Respuesta',
			iconClass: 'aui-diagram-node-end-icon'
		},
		{
			type: 'condition',
			label: 'Pregunta',
			iconClass: 'aui-diagram-node-condition-icon'
		}
	];

	// ahora se llama por ajax
	preguntas = new Array();
	preguntas[0] = "¿Qué servicio desea probar sobre Cloud?";
	preguntas[1] = "¿Cómo se desea comunicar entre su POC y su Cloud?";
	preguntas[2] = "¿Qué tipo de conexión desea?";
	preguntas[3] = "¿Cuentas IPs públicas?";
	preguntas[4] = "¿Qué ancho de banda?";
	
	//ahora se llama por ajax
	respuestas = new Array();
	respuestas[0] = "Web";
	respuestas[1] = "App";
	respuestas[2] = "BBDD";
	respuestas[3] = "TS";
	respuestas[4] = "FServer";

	db1 = new A.DiagramBuilder(
		{
			availableFields: availableFields,
			boundingBox: '#diagrambuilderBB',
			srcNode: '#diagrambuilderCB',
			on: {
				 '*:drag': function(event) {
					 
					 //aca se guardan los cambios de posición en la base de datos.
					A.io.request('ajaxpost.php', {
						autoLoad: true,
						method: 'POST',
						data: {
							nodo: 'add',
							name: 'prueba add en medio del codigo',
							type: 'end',
							posx: 1,
							posy: 1
						},
						on: {
							success: function(data){
								if(data){
									console.log("AJAX", data);
								}
							}
						}
					});
				console.log('drag event', event);
				},
				save: function(event) {
					//aca se guardan los cambios
					console.log('save', event);
				}
			},
			fields: [/*
				{
					name: nodos[0].name,
					type: nodos[0].type,
					xy: [nodos[0].posx, nodos[0].posy]
				},*/
				{
					name: preguntas[0],
					type: typepregunta,
					xy: [50, 60]
				},
				{
					name: respuestas[0],
					type: typerespuesta,
					xy: [250, 60]
				},
				{
					name: respuestas[1],
					type: typerespuesta,
					xy: [250, 130]
				},
				{
					name: respuestas[2],
					type: typerespuesta,
					xy: [250, 200]
				},
				{
					name: respuestas[3],
					type: typerespuesta,
					xy: [250, 270]
				},
				{
					name: respuestas[4],
					type: typerespuesta,
					xy: [250, 350]
				}
			],
			render: true
		}
	);

	// db1.syncTargetsUI();

	// var task2 = db1.addField({
	// 	name: 'Task2',
	// 	type: 'condition'
	// });

	// task2.addTransition('Task1');
	// task2.connect('Task1');
	console.log(preguntas[0],respuestas[0]);
	db1.connectAll([
		{
			connector: { name: '' },
			source: preguntas[0],
			target: respuestas[0]
			
		},
		{
			connector: { name: '' },
			source: preguntas[0],
			target: respuestas[1]
		},
		{
			connector: { name: '' },
			source: preguntas[0],
			target: respuestas[2]
		},
		{
			connector: { name: '' },
			source: preguntas[0],
			target: respuestas[3]
		},
		{
			connector: { name: '' },
			source: preguntas[0],
			target: respuestas[4]
		},
		{
			connector: { name: '' },
			source: preguntas[0],
			target: respuestas[5]
		},
		{
			connector: { name: '' },
			source: 'State0',
			target: 'EndNode0'
		}
	]);

	// db2 = new A.DiagramBuilder(
	// 	{
	// 		after: {
	// 			cancel: function(event) {
	// 				console.log('cancel', event);
	// 			},

	// 			save: function(event) {
	// 				console.log('save', event);
	// 			}
	// 		},
	// 		availableFields: availableFields,
	// 		fields: [
	// 			{
	// 				bodyContent: 'Node1',
	// 				type: 'task',
	// 				xy: [200, 200]
	// 			},
	// 			{
	// 				bodyContent: 'Node2',
	// 				type: 'task'
	// 			}
	// 		],
	// 		render: '#diagramBuilder2'
	// 	}
	// );

});