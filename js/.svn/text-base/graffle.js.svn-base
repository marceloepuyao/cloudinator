Raphael.fn.connection = function (obj1, obj2, line, bg) {
    if (obj1.line && obj1.from && obj1.to) {
        line = obj1;
        obj1 = line.from;
        obj2 = line.to;
    }
    var bb1 = obj1.getBBox(),
        bb2 = obj2.getBBox(),
        p = [{x: bb1.x + bb1.width / 2, y: bb1.y - 1},
        {x: bb1.x + bb1.width / 2, y: bb1.y + bb1.height + 1},
        {x: bb1.x - 1, y: bb1.y + bb1.height / 2},
        {x: bb1.x + bb1.width + 1, y: bb1.y + bb1.height / 2},
        {x: bb2.x + bb2.width / 2, y: bb2.y - 1},
        {x: bb2.x + bb2.width / 2, y: bb2.y + bb2.height + 1},
        {x: bb2.x - 1, y: bb2.y + bb2.height / 2},
        {x: bb2.x + bb2.width + 1, y: bb2.y + bb2.height / 2}],
        d = {}, dis = [];
    for (var i = 0; i < 4; i++) {
        for (var j = 4; j < 8; j++) {
            var dx = Math.abs(p[i].x - p[j].x),
                dy = Math.abs(p[i].y - p[j].y);
            if ((i == j - 4) || (((i != 3 && j != 6) || p[i].x < p[j].x) && ((i != 2 && j != 7) || p[i].x > p[j].x) && ((i != 0 && j != 5) || p[i].y > p[j].y) && ((i != 1 && j != 4) || p[i].y < p[j].y))) {
                dis.push(dx + dy);
                d[dis[dis.length - 1]] = [i, j];
            }
        }
    }
    if (dis.length == 0) {
        var res = [0, 4];
    } else {
        res = d[Math.min.apply(Math, dis)];
    }
    var x1 = p[res[0]].x,
        y1 = p[res[0]].y,
        x4 = p[res[1]].x,
        y4 = p[res[1]].y;
    dx = Math.max(Math.abs(x1 - x4) / 2, 10);
    dy = Math.max(Math.abs(y1 - y4) / 2, 10);
    var x2 = [x1, x1, x1 - dx, x1 + dx][res[0]].toFixed(3),
        y2 = [y1 - dy, y1 + dy, y1, y1][res[0]].toFixed(3),
        x3 = [0, 0, 0, 0, x4, x4, x4 - dx, x4 + dx][res[1]].toFixed(3),
        y3 = [0, 0, 0, 0, y1 + dy, y1 - dy, y4, y4][res[1]].toFixed(3);
    var path = ["M", x1.toFixed(3), y1.toFixed(3), "C", x2, y2, x3, y3, x4.toFixed(3), y4.toFixed(3)].join(",");
    if (line && line.line) {
        line.bg && line.bg.attr({path: path});
        line.line.attr({path: path});
    } else {
        var color = typeof line == "string" ? line : "#000";
        return {
            bg: bg && bg.split && this.path(path).attr({stroke: bg.split("|")[0], fill: "none", "stroke-width": bg.split("|")[1] || 3}),
            line: this.path(path).attr({stroke: color, fill: "none"}),
            from: obj1,
            to: obj2
        };
    }
};

var el;
window.onload = function () {
    var clicking = function () {
        //this.hide();
    	//this.node.style.display = "none";
    	console.log(connections);
       console.log(connections[0]);
       var a = 0;
       var b = 0;
       for(var i = connections.length; i--;){
    	   if(connections[i].from == this){
    		   /*
    		   connections = jQuery.grep(connections, function(value) {
    			   return value != connections[i];
    			 });
    		   
    		   r.safari();
    		   */
    		   a++;
    	   }
    	   if(connections[i].to== this){
    		   b++;
    	   }
    	  
    	   
       }
       
       /*
       for(var p = arra.length;p--;){
       	connections.push(arra[p]);
   		}
   		*/
   		
       /*
       for (var i = connections.length; i--;) {
           r.connection(connections[i]);
       }
       */
       //r.safari();
       alert('tienes ' +a + 'hijos y ' + b + 'padres');

    };
    var px = 40;
    var py = 20;
    
    var dragger = function () {
        this.ox = this.type == "rect" ? this.attr("x") : this.attr("cx");
        this.oy = this.type == "rect" ? this.attr("y") : this.attr("cy");
        //this.animate({"fill-opacity": .2}, 500);
        
        this.pair.ox = this.pair.type == "rect" ? this.pair.attr("cx") : this.pair.attr("x");
        this.pair.oy = this.pair.type == "rect" ? this.pair.attr("cy") : this.pair.attr("y");
        if (this.pair.type != "text") this.pair.animate({"fill-opacity": .2}, 500);            
    
        
        },
        move = function (dx, dy) {
            var att = this.type == "rect" ? {x: this.ox + dx, y: this.oy + dy} : {cx: this.ox + dx, cy: this.oy + dy};
            this.attr(att);
            
            att = this.pair.type == "rect" ? 
                    {cx: this.pair.ox + dx, cy: this.pair.oy + dy} : 
                    {x: this.pair.ox + dx, y: this.pair.oy + dy};
            this.pair.attr(att);
            
            for (var i = connections.length; i--;) {
                r.connection(connections[i]);
            }
            r.safari();
        },
        up = function () {
            this.animate({"fill-opacity": 0}, 500);
        },
        r = Raphael("holder", 8000, 550),
        connections = [],
        shapes = [  r.ellipse(150, 220, 90, 40, 10),
                    r.rect(300, 80, 80, 40, 10),
                    r.rect(300, 140, 80, 40, 10),
                    r.rect(300, 200, 80, 40, 10),
                    r.rect(300, 260, 80, 40, 10),
                    r.rect(300, 310, 80, 40, 10),
                    r.ellipse(550, 220, 90, 40, 10),
                    r.rect(650, 140, 80, 40, 10),
                    r.rect(650, 260, 80, 40, 10),
                    r.ellipse(850, 120, 90, 40, 10),
                    r.rect(1000, 50, 80, 40, 10),
                    r.rect(1000, 120, 80, 40, 10),
                    r.rect(1000, 170, 80, 40, 10),
                    r.ellipse(850, 220, 90, 40, 10),
                    r.ellipse(850, 310, 90, 40, 10),
                    r.rect(1000, 220, 80, 40, 10),
                    r.rect(1000, 310, 80, 40, 10),
                ],
        texts = [  r.text(150, 220, "Que servicio desea \n probar sobre Cloud?"),
                   r.text(300+ px, 80+ py, "Web"),
                   r.text(300+ px, 140+ py, "App"),
                   r.text(300+ px, 200+ py, "BBDD"),
                   r.text(300+ px, 260+ py, "TS"),
                   r.text(300+ px, 310+ py, "FServer"),
                   r.text(550, 220, "Como se desea comunicar \n entre su POC y Cloud?"),
                   r.text(650+ px, 140+ py, "VLAN"),
                   r.text(650+ px, 260+ py, "Prepicado"),
                   r.text(850, 120, "Que tipo de conexion?"),
                   r.text(1000+ px, 50+ py, "VPN"),
                   r.text(1000+ px, 120+ py, "Site to Site"),
                   r.text(1000+ px, 170+ py, "VPN cliente"),
                   r.text(850, 220, "Cuantas IPs publicas?"),
                   r.text(850, 310, "Que ancho de banda?"),
                   r.text(1000+ px, 220+ py, "Ingrese n#"),
                   r.text(1000+ px, 310+ py, "Ingrese n#"),
              ];
    for (var i = 0, ii = shapes.length; i < ii; i++) {
        var color = Raphael.getColor();
        tempS = shapes[i].attr({fill: color, stroke: 'white', "fill-opacity": 0, "stroke-width": 2, cursor: "move"});
        tempT = texts[i].attr({fill: 'white', stroke: "none", "font-size": 15, cursor: "move"});
        console.log(tempT);
        
        shapes[i].click(clicking);
        shapes[i].drag(move, dragger, up);
        
        //texts[i].click(clicking);
        texts[i].drag(move, dragger);
        
        tempS.pair = tempT;
        tempT.pair = tempS;
        
    }
   
    //if(shapes[0].node.style.display == "none"){
    arra = [
				r.connection(shapes[0], shapes[1], "#fff"),
				r.connection(shapes[0], shapes[2], "#fff", "#fff"),
				r.connection(shapes[0], shapes[3], "#001", "#fff"),
				r.connection(shapes[0], shapes[4], "#010", "#fff"),
				r.connection(shapes[0], shapes[5], "#100", "#fff"),
				
				r.connection(shapes[1], shapes[6], "#000", "#fff"),
				r.connection(shapes[2], shapes[6], "#000", "#fff"),
				r.connection(shapes[3], shapes[6], "#000", "#fff"),
				r.connection(shapes[4], shapes[6], "#000", "#fff"),
				r.connection(shapes[5], shapes[6], "#000", "#fff"),
				
				r.connection(shapes[6], shapes[7], "#000", "#fff"),
				r.connection(shapes[6], shapes[8], "#000", "#fff"),
				
				r.connection(shapes[7], shapes[9], "#000", "#fff"),
				
				r.connection(shapes[9], shapes[10], "#000", "#fff"),
				r.connection(shapes[9], shapes[11], "#000", "#fff"),
				r.connection(shapes[9], shapes[12], "#000", "#fff"),
				
				r.connection(shapes[7], shapes[13], "#000", "#fff"),
				r.connection(shapes[7], shapes[14], "#000", "#fff"),
				r.connection(shapes[8], shapes[13], "#000", "#fff"),
				r.connection(shapes[8], shapes[14], "#000", "#fff"),
				
				r.connection(shapes[13], shapes[15], "#000", "#fff"),
				r.connection(shapes[14], shapes[16], "#000", "#fff"),
            
            ];
    
    for(var p = arra.length;p--;){
    	connections.push(arra[p]);
	}
    //}
    
    
};
