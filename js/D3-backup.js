$(document).ready(function(){

	var whereiam = null, //para seguir el nodo donde estoy parado en cada momento, se actualiza en la funcion update. KJ.
		stepnumber = 0,
		navbarmemory = new Array();

	//tamaños iniciales, parametricos segun el tamaño del navegador. KJ.
	var w = $(document).width()*(0.95),
		h = $(document).height()*(0.8)-120, //el 120 es para darle espacio al navbar, titulo y linea de separación. KJ.
		i = 0,
		duration = 500,
		root;

	var tree = d3.layout.tree().size([h, w * 0.7]);

	var diagonal = d3.svg.diagonal()
		.projection(function(d) {
			return [d.y, d.x];
		});
	var sangria = (w*0.3)/2;
	var vis = d3.select("#chart").append("svg:svg")
		.attr("width", w)
		.attr("height", h)
		.append("svg:g")
		.attr("transform", "translate("+sangria+",0)")
		.attr("id","gBase");

	//este evento se ejecuta al cambiar el tamaño de la ventana, actualiza el arbol para que se ajuste adecuadamente. KJ.
	$(window).resize(function() {
		w = $(window).width()*(0.95);
		h = $(window).height()*(0.8)-120;
		sangria = (w*0.3)/2;
		tree = d3.layout.tree().size([h, w * 0.7]);
		$("#chart").find('svg').attr("width", w).attr("height", h);
		$('#gBase').attr("transform", "translate("+sangria+",0)");
		update(whereiam);
	});

	//este evento es para cuando se hace click en el navbar (migas de pan), es una especie de "undo". KJ.
	$('.breadcrumbs').on('click','li', function(){
		for (var i = stepnumber; i > $(this).data('stepnumber'); i--) {
			click(navbarmemory[i]);
		}
	});
	function uncollapse(d) {
    	if (d._children) {
    		d.children = d._children;
    		d.children.forEach(uncollapse);
    		d._children = null;
    	}
	}
	function collapse(d) {
    	if (d.children) {
    		d._children = d.children;
    		d._children.forEach(collapse);
    		d.children = null;
    	}
	}
	 
	d3.json("js/flare.json", function(json) {
		root = json;
		json.x0 = 800;
		json.y0 = 0;

		json.children.forEach(collapse);

		navbarmemory[0] = json; // creo que no funciona/no es necesario. KJ.
		update(json);
	});
	/* funci�n para ver todo el �rbol
	$('#viewall').on('click', function(){
		var allroot = root;
		
		allroot.children.forEach(uncollapse);
		
		update(allroot);
	});
	*/
	function update(source, bool) {
		//alert('asada');
	 
		console.log(source); //HAY QUE IR GUARDANDO ESTA INFO ;) / [yo creo que no, hay que guardarla dentro de la funcion click. KJ.]
		whereiam = source; //se actualiza el nodo en el que se está parado para poder hacer el resize. KJ.

	
		var nodes = tree.nodes(source).reverse();
		
		//console.log(nodes);
	
		// Update the nodes…
		var node = vis.selectAll("g.node")
		
		.data(nodes, function(d) { return d.id || (d.id = ++i); });
		var nodeEnter = node.enter().append("svg:g")
		.attr("class", "node")
		.attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; });
		//.style("opacity", 1e-6);
		// Enter any new nodes at the parent's previous position.
		nodeEnter.append("svg:circle")
		//.attr("class", "node")
		//.attr("cx", function(d) { return source.x0; })
		//.attr("cy", function(d) { return source.y0; })
		.attr("r", 7)
		.style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; })
		.on("click", click);
		
		nodeEnter.append("svg:text")
		.attr("x", function(d) { return d._children ? 15 : 15; })
		.attr("y", 3)
		//.attr("fill","#ccc")
		//.attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })
		.text(function(d) { return d.name; }).on("click", click);
		
		// Transition nodes to their new position.
		nodeEnter.transition()
		.duration(duration)
		.attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })
		.style("opacity", 1)
		.select("circle")
		//.attr("cx", function(d) { return d.x; })
		//.attr("cy", function(d) { return d.y; })
		.style("fill", "lightsteelblue");
		node.transition()
		.duration(duration)
		.attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; })
		.style("opacity", 1);
		 
		node.exit().transition()
		.duration(duration)
		.attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
		.style("opacity", 1e-6)
		.remove();
		
		/*
		var nodeTransition = node.transition()
		.duration(duration);
		nodeTransition.select("circle")
		.attr("cx", function(d) { return d.y; })
		.attr("cy", function(d) { return d.x; })
		.style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });
		nodeTransition.select("text")
		.attr("dx", function(d) { return d._children ? -8 : 8; })
		.attr("dy", 3)
		.style("fill", function(d) { return d._children ? "lightsteelblue" : "#5babfc"; });
		 
		// Transition exiting nodes to the parent's new position.
		var nodeExit = node.exit();
		nodeExit.select("circle").transition()
		.duration(duration)
		.attr("cx", function(d) { return source.y; })
		.attr("cy", function(d) { return source.x; })
		.remove();
		nodeExit.select("text").transition()
		.duration(duration)
		.remove();
		*/
		// Update the links…
		var link = vis.selectAll("path.link")
		.data(tree.links(nodes), function(d) { return d.target.id; });
		 
		// Enter any new links at the parent's previous position.
		link.enter().insert("svg:path", "g")
		.attr("class", "link")
		.attr("d", function(d) {
		var o = {x: source.x0, y: source.y0};
		return diagonal({source: o, target: o});
		})
		.transition()
		.duration(duration)
		.attr("d", diagonal);
		 
		// Transition links to their new position.
		link.transition()
		.duration(duration)
		.attr("d", diagonal);
		 
		// Transition exiting nodes to the parent's new position.
		link.exit().transition()
		.duration(duration)
		.attr("d", function(d) {
		var o = {x: source.x, y: source.y};
		return diagonal({source: o, target: o});
		})
		.remove();
			 
		// Stash the old positions for transition.
		nodes.forEach(function(d) {
		d.x0 = d.x;
		d.y0 = d.y;
		});
		
		//alert(source.children.length);
		/*
		if(source.children.length == 1){
			source.children[0].children = source.children[0]._children;
			source.children[0]._children = null;
			update(source.children[0]);
		}
		*/
	}
	 
	// Toggle children on click.
	function click(d) {

		if (d.children) {
			d.children.forEach(collapse);
			
			if(d.parent){
				stepnumber--;
				//el breadcrumbs (migas de pan) es el navbar, remueve la ultima miga de pan al retroceder.
				$('.breadcrumbs').find('li').last().fadeOut();
				$('.breadcrumbs').find('li').last().prev().addClass('last');
				$('.breadcrumbs').find('li').last().remove();
				
				if (d.parent._children) {
					d.parent.children = d.parent._children;
					d.parent._children = null;
				}
				d._children = d.children;
				d.children = null;
				update(d.parent);
			}else{
				alert('este es el primer nodo');
				update(d);
			}
		} else if(d._children){
			stepnumber++; //sumo +1 al stepnumber cada vez que se hace click en un nodo
			navbarmemory[stepnumber] = d;
			//el breadcrumbs (migas de pan) es el navbar, agrega los elementos al hacer click en el nodo siguiente (avanzar). KJ.
			var text = $(this).closest('g').find('text').first().text();
			$('.last').removeClass('last');
			$('.breadcrumbs').append('<li class="last" data-stepnumber="'+stepnumber+'"><a>'+text+'</a></li>');
			$('.breadcrumbs').children().last().hide();
			$('.breadcrumbs').children().last().fadeIn();

			d.children = d._children;
			d._children = null;
			update(d);

		}else{
			alert('ha llegado al final');
		}	
	}
	
	

	d3.select(self.frameElement).style("height", "2000px"); //estoy intrigado por saber que hace esto. KJ.
	
});

/*
var treeData = new Object();
treeData.name = $('#0').data('name');
treeData.info = "tst";
treeData.children = new Array();//{"name" :$('#first').children("li").first().data('name') };


	for (var i = 0; i < $('#0').children("p").length; i++) {			
	
		var first_json = {"name" : $('#0').children("p").slice(i,i+1).data('name') };
		treeData.children.push(first_json);
		
		for (var i = 0; i < $('#'+ $('#0').children("li").data('name').toString()).children("li").length; i++) {			
			
			var first_json = {"name" : $('#0').children("li").slice(i,i+1).data('name') };
			treeData.children.push(first_json);
		}
		
		
	}
*/