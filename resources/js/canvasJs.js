
var mrtCanvas = "#mrtCanvas";
origami(mrtCanvas).background('#FFFFFF').draw();

var c = 0;
function dispImage(e,imgfile,x,y,w,h) {
	c = c + 1;
	//alert("c="+c+": "+e.type+": "+imgfile);
 	origami(mrtCanvas)
		.image(imgfile,x,y,w,h)
		.load(function(foo) {
			foo.draw();
		});
}

function eraseDFail(n,x,y,w,h){
 	// n = attempt failure (n=1,2,3) M2B
 	// n = attempt failure (n=4,5,6) B2M
	switch(n) {
		case 1:
			drawThinLine(3,459,263,415,318,'white');
			break;
		case 2:
			drawThinLine(3,481,238,454,192,'white');
			drawThinLine(3,454,193,343,161,'white');
			break;
		case 3:
			drawThinLine(3,503,237,491,160,'white');
			break;
		case 4:
			drawThinLine(3,913,142,726,90,'white');
			break;
		case 5:
			drawThinLine(3,935,142,871,90,'white');
			break;
		case 6:
			drawThinLine(3,956,142,956,30,'white');
			drawThinLine(3,956,30,1030,30,'white');
			break;
		default:
	}
 
	origami(mrtCanvas)
		.rect(x, y, w, h, {
		background: 'white',
		border: '2px solid white',
	}).draw();
}
 
function drawDFail(n,ddate,x,y,w,h,c){
	var circleSize = 11;
    if(c == '') c ='#FF3333';
    //console.log(c);

 	origami(mrtCanvas)
		.rect(x, y, w, h, {
		background: '#f2f464',
		border: '1px solid '+c,
	}).draw(); 

	// Location of text for the 3 failure boxes
	x1=416;  y1=333;
	x2=341;  y2=115;
	x3=490;  y3=115;
	x4=725;  y4=45;
	x5=870;  y5=45;
	x6=1090; y6=15;

	// n = attempt failure (n=1,2,3)
	switch(n) {
		case 1:
			drawThinLine(1,459,263,415,318,c);
			writeBoldText("Delivery:",x1,y1);
			writeText("1st. Attempt",x1,y1+circleSize);
			writeText(ddate,x1,y1+(2*circleSize));
			break;
		case 2:
			drawThinLine(1,481,237,454,193,c);
			drawThinLine(1,454,193,344,161,c);
			writeBoldText("Delivery:",x2,y2);
			writeText("2nd. Attempt",x2,y2+circleSize);
			writeText(ddate,x2,y2+(2*circleSize));
			break;
		case 3:
			drawThinLine(1,503,237,491,160,c);
			writeBoldText("Delivery:",x3,y3);
			writeText("3rd. Attempt",x3,y3+circleSize);
			writeText(ddate,x3,y3+(2*circleSize));
			break;
 		case 4:
			drawThinLine(1,912,142,726,90,c);
			writeBoldText("Return Delivery:",x4,y4);
			writeText("1st. Attempt",x4,y4+circleSize);
			writeText(ddate,x4,y4+(2*circleSize));
			break; 
  		case 5:
			drawThinLine(1,934,142,871,90,c);
			writeBoldText("Return Delivery:",x5,y5);
			writeText("2nd. Attempt",x5,y5+circleSize);
			writeText(ddate,x5,y5+(2*circleSize));
			break;  
   		case 6:
			drawThinLine(1,956,142,956,30,c);
			drawThinLine(1,956,30,1030,30,c);
			writeBoldText("Return Delivery:",x6,y6);
			writeText("3rd. Attempt",x6,y6+circleSize);
			writeText(ddate,x6,y6+(2*circleSize));
			break;   
		default:
	}
}

function drawApproval(x,y,s,c){
    if(c == '') {
  		origami(mrtCanvas)
			.styles('.appr_square')
			.shape('.appr_square')
			.draw();
	} else {
  		origami(mrtCanvas)
			.styles('.appr_square_completed')
			.shape('.appr_square_completed')
			.draw();  
	}
}
 

function drawRect(x,y,w,h,c){
    if(c == '') c ='#FF3333';
    //console.log(c);

	origami(mrtCanvas)
		.rect(x, y, w, h, {
		background:c,
	}).draw();
}

function drawRectH(x,y,w,h){
	origami(mrtCanvas)
		.rect(x, y, w, h, {
			background: '#FF3333',
			border: '1px solid #666666'
		}).draw();
}

function drawThinLine(a,x,y,w,h,c){
    if(c == '') c = '#808080';

	var styleLine = {
        border: a+'px '+'solid '+c
	};

	origami(mrtCanvas)
		.line({x: x, y: y},
			{x: w, y: h},
			styleLine)
		.draw();
}
 

function drawLine(x,y,w,h,c){
    if(c == '') c = '#808080';

	var styleLine = {
        border: '13px' + 'solid' + c
	};

	origami(mrtCanvas)
		.line({x: x, y: y},
			{x: w, y: h},
			styleLine)
		.draw();
}

function drawArc(x,y,w,h,s,c){
    if(s == '') s = 'solid';
    if(c == '') c = '#808080';

	var styleLine = {
        border: '2px' + s + c
	};

	origami(mrtCanvas)
		.arc(200, 300, 10,  styleLine)
		.draw();
}

function drawFilledCircle(x,y,w,o,color){
    if(color == '')
        color = '#808080';

	var style = {
		background: color,
		borderColor: color,
		borderSize: '4px',
		borderStyle: 'solid'
	};

	origami(mrtCanvas)
		.arc(x, y, w, style)
		.opacity(o)
		.draw();
}

function drawCircle(x,y,w,o ,border){
    if(border == '')
        border = '#808080';

	var style = {
		background: '#FFFFFF',
		borderSize: '4px',
		borderColor: border,
		borderStyle: 'solid'
	};

	origami(mrtCanvas)
		.arc(x, y, w, style)
		.opacity(o)
		.draw();
}

function writeTextLeft(text,x,y,color){
    if(color == '')
        color = '#808080';

    //console.log(color);
    var style = {
        color:color,
        font: '10px Helvetica',
        align: 'left',
    };

    origami(mrtCanvas)
		.text(text, x, y, style)
		.draw();
}

function writeBoldText(text,x,y,color){
    if(color == '')
        color = '#808080';

    //console.log(color);
    var style = {
        color:color,
        font: 'bold 10px Helvetica',
        align: 'center',
    };

    origami(mrtCanvas)
		.text(text, x, y, style)
		.draw();
}
 
 

function writeText(text,x,y,color){
    if(color == '')
        color = '#808080';

    //console.log(color);
    var style = {
        color:color,
        font: '10px Helvetica',
        align: 'center',
    };

    origami(mrtCanvas)
		.text(text, x, y, style)
		.draw();
}

