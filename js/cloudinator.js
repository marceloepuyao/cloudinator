
var nodos = new Array();
var links = new Array();
AUI().use('aui-io-request', 'aui-diagram-builder', function(A){

	A.io.request('ajaxnodos.php', {
		cache: false,
		autoLoad: true,
		dataType: 'json',   on: {   
			success: function() {					
				var datos = this.get('responseData');
				for (var i=0; i < datos.length; i++) {
		   			nodos[i] = datos[i];
	   			} 
				cargaNodos();
				andaABuscarLosLinks();
			}
		}
	});

	function andaABuscarLosLinks() {
		A.io.request('ajaxlinks.php', {
			dataType: 'json',   on: {   
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
/*
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
*/
//y esto? no va en funcion?
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

	function cargaNodos() {
		console.log('nodos', nodos[0]);
		db1 = new A.DiagramBuilder(
			{
				availableFields: availableFields,
				boundingBox: '#diagrambuilderBB',
				srcNode: '#diagrambuilderCB',
				on: {
					 '*:drag': function(event) {
						 
						//aca se guardan los cambios de posición en la base de datos.
						/*
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
						*/
					console.log('drag event', event);
					},
					save: function(event) {
						//aca se guardan los cambios
						console.log('save', event);
					}
				},

				fields: [
					{
						name: nodos[0].name,
						type: nodos[0].type,
						xy: [parseInt(nodos[0].posx), parseInt(nodos[0].posy)]
					},
					{
						name: nodos[0].name,
						type: nodos[0].type,
						xy: [parseInt(nodos[1].posx), parseInt(nodos[1].posy)]
					},
					{
						name: nodos[0].name,
						type: nodos[0].type,
						xy: [parseInt(nodos[2].posx), parseInt(nodos[2].posy)]
					},
					{
						name: nodos[0].name,
						type: nodos[0].type,
						xy: [parseInt(nodos[3].posx), parseInt(nodos[3].posy)]
					},
					{
						name: nodos[0].name,
						type: nodos[0].type,
						xy: [parseInt(nodos[4].posx), parseInt(nodos[4].posy)]
					},
					{
						name: nodos[5].name,
						type: nodos[5].type,
						xy: [parseInt(nodos[5].posx), parseInt(nodos[5].posy)]
					},
					{
						name: nodos[6].name,
						type: nodos[6].type,
						xy: [parseInt(nodos[6].posx), parseInt(nodos[6].posy)]
					},
					{
						name: nodos[7].name,
						type: nodos[7].type,
						xy: [parseInt(nodos[7].posx), parseInt(nodos[7].posy)]
					},
					{
						name: nodos[8].name,
						type: nodos[8].type,
						xy: [parseInt(nodos[8].posx), parseInt(nodos[8].posy)]
					},
					{
						name: nodos[9].name,
						type: nodos[9].type,
						xy: [parseInt(nodos[9].posx), parseInt(nodos[9].posy)]
					}
				],
				render: true
			}
		);
	}
	// db1.syncTargetsUI();

	// var task2 = db1.addField({
	// 	name: 'Task2',
	// 	type: 'condition'
	// });

	// task2.addTransition('Task1');
	// task2.connect('Task1');
	
	function cargaLinks() {
		console.log('links', links[0]);
		db1.connectAll([
			{
				connector: { name: links[0].name },
				source: parseInt(links[0].source),
				target: parseInt(links[0].target)
			},
			{
				connector: { name: links[1].name },
				source: parseInt(links[1].source),
				target: parseInt(links[1].target)
			},
			{
				connector: { name: links[2].name },
				source: parseInt(links[2].source),
				target: parseInt(links[2].target)
			},
			{
				connector: { name: links[3].name },
				source: parseInt(links[3].source),
				target: parseInt(links[3].target)
			},
			{
				connector: { name: links[4].name },
				source: parseInt(links[4].source),
				target: parseInt(links[4].target)
			}
		]);
	}
	
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