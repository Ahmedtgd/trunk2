var canvas;var context;var paint = false;
//var canvasWidth = window.innerWidth;//490;
//var canvasHeight = window.innerHeight;220;
var canvasWidth = window.innerWidth - 100;
var canvasHeight = window.innerHeight - 150;
var lineWidth = 8;
var colorPurple = "#cb3594";var colorGreen = "#659b41";var colorYellow = "#ffcf33";var colorBrown = "#986928";var colorDarkBlue="#00008B";
var curColor = colorDarkBlue;
var clickX = new Array();var clickY = new Array();var clickDrag = new Array();

function removeCanvasb()
{
	var parent = document.getElementById('canvasDivb');
    var child = document.getElementById("canvasb");

    if(child != null)
        parent.removeChild(child);
}

function prepareCanvasb()
{
    removeCanvasb();
	// Create the canvas (Neccessary for IE because it doesn't know what a canvas element is)
	var canvasDiv = document.getElementById('canvasDivb');
	canvas = document.createElement('canvas');
	canvas.setAttribute('id', 'canvasb');
	canvas.setAttribute('width', canvasWidth);
	canvas.setAttribute('height', canvasHeight);
	canvasDiv.appendChild(canvas);

	if(typeof G_vmlCanvasManager != 'undefined') {
		canvas = G_vmlCanvasManager.initElement(canvas);
	}
	canvas = document.getElementById('canvasb');

	context = canvas.getContext("2d"); // Grab the 2d canvas context

	// Note: The above code is a workaround for IE 8 and lower. Otherwise we could have used:
	//     context = document.getElementById('canvas').getContext("2d");
	// Add mouse events
	// ----------------

	var $canvas = $("#canvasb");
	var canvasOffset = $canvas.offset();
	var offsetX =canvasOffset.left;
	var offsetY =canvasOffset.top;

	$('#canvasb').mousedown(function(e)
	{
		// Mouse down location
		var mouseX = e.pageX - this.offsetLeft;
		var mouseY = e.pageY - this.offsetTop;

		//var mouseX = e.clientX - offsetX;
		//var mouseY = e.clientY - offsetY;

		paint = true;
		addClick(mouseX, mouseY, false);
		redraw();
	});

	$('#canvasb').mousemove(function(e){
		if(paint==true){
			addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
			redraw();
		}
	});

	$('#canvasb').mouseup(function(e){
		paint = false;
		redraw();
	});

	$('#canvasb').mouseleave(function(e){
		paint = false;
	});
}

function removeCanvas()
{
	var parent = document.getElementById('canvasDiv');
    var child = document.getElementById("canvas");

    if(child != null)
        parent.removeChild(child);
}

function prepareCanvas()
{
    removeCanvas();
	// Create the canvas (Neccessary for IE because it doesn't know what a canvas element is)
	var canvasDiv = document.getElementById('canvasDiv');
	canvas = document.createElement('canvas');
	canvas.setAttribute('id', 'canvas');
	canvas.setAttribute('width', canvasWidth);
	canvas.setAttribute('height', canvasHeight);
	canvasDiv.appendChild(canvas);

	if(typeof G_vmlCanvasManager != 'undefined') {
		canvas = G_vmlCanvasManager.initElement(canvas);
	}
	canvas = document.getElementById('canvas');
	context = canvas.getContext("2d"); // Grab the 2d canvas context

	// Note: The above code is a workaround for IE 8 and lower. Otherwise we could have used:
	//     context = document.getElementById('canvas').getContext("2d");
	// Add mouse events
	// ----------------

	var $canvas = $("#canvas");
	var canvasOffset = $canvas.offset();
	var offsetX =canvasOffset.left;
	var offsetY =canvasOffset.top;

	$('#canvas').mousedown(function(e)
	{
		// Mouse down location
		var mouseX = e.pageX - this.offsetLeft;
		var mouseY = e.pageY - this.offsetTop;

		//var mouseX = e.clientX - offsetX;
		//var mouseY = e.clientY - offsetY;

		paint = true;
		addClick(mouseX, mouseY, false);
		redraw();
	});

	$('#canvas').mousemove(function(e){
		if(paint==true){
			addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
			redraw();
		}
	});

	$('#canvas').mouseup(function(e){
		paint = false;
		redraw();
	});

	$('#canvas').mouseleave(function(e){
		paint = false;
	});
}

/**
 * Adds a point to the drawing array.
 * @param x
 * @param y
 * @param dragging
 */
function addClick(x, y, dragging)
{
	clickX.push(x);
	clickY.push(y);
	clickDrag.push(dragging);
}

/**
 * Clears the canvas.
 */
function clearCanvas()
{
	context.clearRect(0, 0, canvasWidth, canvasHeight);
	clickX = [];
	clickY = [];
	clickDrag = [];
}

/**
 * Redraws the canvas.
 */

function redraw(){
	//clearCanvas();

	context.strokeStyle = curColor;
	context.lineJoin = "round";
	context.lineWidth = 5;

	for(var i=0; i < clickX.length; i++) {
		context.beginPath();

		if(clickDrag[i] && i){
			context.moveTo(clickX[i-1], clickY[i-1]);
		}else{
			context.moveTo(clickX[i]-1, clickY[i]);
		}
		context.lineTo(clickX[i], clickY[i]);
		context.closePath();
		context.stroke();
	}
}