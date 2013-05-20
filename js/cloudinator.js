AUI().use('aui-diagram-builder', function(A) {
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

	//var connection = new ActiveXObject("ADODB.Connection") ;
	/*
	var connectionstring="Data Source=localhost;Initial Catalog=<catalog>;User ID=root;Password=;Provider=SQLOLEDB";

	connection.Open(connectionstring);
	var rs = new ActiveXObject("ADODB.Recordset");

	rs.Open("SELECT * FROM table", connection);
	rs.MoveFirst;
	while(!rs.eof)
	{
	   document.write(rs.fields(1));
	   rs.movenext;
	}

	rs.close;
	connection.close;
	*/

	preguntas = new Array();
	$.getJSON('ajaxpreg.php', function(data){
		$.each(data, function (index, value) {
			alert(index+' '+value)
       		preguntas[index] = value;
    	});
	});

    alert(preguntas[0]);
	/*
	preguntas = new Array();
	preguntas[0] = "¿Qué servicio desea probar sobre Cloud?";
	preguntas[1] = "¿Cómo se desea comunicar entre su POC y su Cloud?";
	preguntas[2] = "¿Qué tipo de conexión desea?";
	preguntas[3] = "¿Cuentas IPs públicas?";
	preguntas[4] = "¿Qué ancho de banda?";
	*/

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
				 	console.log('abc', event);
					 
				 },
				save: function(event) {
					//aca se guardan los cambios
					console.log('save', event);
				}
			},
			fields: [
				{	/*
					 transitions: [
					 	'Task1',
					 	{ target: 'Task0' }
					 ],*/
					name: preguntas[0],
					type: typepregunta,
					xy: [10, 200]
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
				},
				{
					name: "asas",
					type: typerespuesta,
					xy: [600, 10]
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