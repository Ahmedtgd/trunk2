/*
   Structure:
   cm.porder_id
   cm.product_id
   cm.thumb_photo
   cm.comment

   Thumbnail's path:
   "images/product/{product_id}/thumb/{thumb_photo}"
*/

/* Thumhnail height */
var thumbh = 40;

/* Table start */
var ts = 1280;

/* Table height */
th = comment.length * thumbh;

/* Width of text block */
var width = 200;

// Process line into block of text
var lines = [], line = '', line_test = '', currentY = 0, h = 0;
var cmnts = [], theight = 0;

var nlines = [], nline = '';
var sthumbh = 0;

// Measuring the height of the comments
var j = 0;
comment.forEach(function(cm) {
	var text = cm.comment;
	var words = text.split(' ');
	nlines = [];
	nline = '';

	//console.log('********** j='+j+' New Comment *************');

	for (var i=0, len=words.length; i<len; i++) {
		line_test = nline + words[i] + ' ';

		// Check total width of line or last word
		//console.log('words['+i+']='+words[i]+", measureText.width="+ c.measureText(line_test).width+', len='+len);

		if (c.measureText(line_test).width > width) {
			// Calculate the new height
			currentY = (lines.length * circleSize) + circleSize;

			// Record and reset the current line
			lines.push({ text: line, height: currentY });
			line = words[i] + ' ';

			// Don't include null or blank spaces
			if (nline != '') {
				nlines.push({ text: nline, height: currentY });
			}
			nline = words[i] + ' ';

			//console.log('nline1='+nline+' currentY='+currentY);

		} else {
			line = line_test;
			nline = line_test;
			//console.log('i='+i+', len='+len+' ELSE :'+nline);
			//console.log('nline2='+nline);
		}

		//console.log("-------- i="+i+" -----------------");
		//console.log(i+": "+nline);
	}

	// Catch last line in-case something is left over
	if (line.length > 0) {
		//console.log('OUTLOOP: '+line.length+': line='+line);
		currentY = (lines.length * circleSize) + circleSize;
		lines.push({ text: line.trim(), height: currentY });
		nlines.push({ text: nline.trim(), height: currentY });
	}

	//console.log('lines.height='+lines[lines.length-1].height);
	//console.log(nlines);
	cmnts.push(nlines);

	// Figure out if comment height is less than thumbnail
	var l = nlines.length - 1;
	var h = nlines[l].height; 
	if (h < thumbh) {
		sthumbh = sthumbh + thumbh;
	}

	j = j+1;
});


/* 176 + 2*15 + 1*20 = 226 */
/* 33 + 30 + 20 + 40 = 123 */

theight = nlines[nlines.length-1].height +
	cmnts.length*(15) + (cmnts.length-1)*20 + sthumbh;

ystart = cy = centerLine - (theight/2);
//console.log('0. cy='+cy+', centerLine='+centerLine+', theight='+theight);


if(cmt_tog == false) {
	var k=0, imgfile;
	//writeTextLeft("Comment ON!", 30,60, '#405500');
	cmt_tog = true;

	origami("#mrtCanvas").styles(".commented-white").
		shape(".commented-white").draw();
 	origami("#mrtCanvas").styles(".commented-completed").
		shape(".commented-completed").draw();
 
	//console.log("cy="+cy);

	comment.forEach(function(cm) {
		var text  = cm.comment;
		var pid   = cm.product_id;	// product.id
		var tnail = cm.thumb_photo;	// path of thumbnail image
		var nlines = cmnts[k];

 		var l = nlines.length - 1;
		var h = nlines[l].height; 

		// Truncate product name if too long
		if (cm.name.length > 40) {
			pname = cm.name.substring(0,40) + "...";
		} else {
			pname = cm.name;
		}

		//console.log('********************* k='+k+' ***********************');
		//console.log('k='+k+', nlines.length='+nlines.length+', '+ nlines[0].height+', cy='+cy);

		//console.log(nlines);

		//console.log(l);
		//console.log('nlines['+ l + '].height='+h);

		// Assemble thumbnail image filename
   		imgfile = "/images/product/"+pid+"/thumb/"+tnail;

		dispImage(e,imgfile,ts,cy+nlines[0].height,thumbh,thumbh);

		writeTextLeft(pname, ts+thumbh+5, cy+nlines[0].height,"black");

 		// Visually output text
		for (var i = 0, len = nlines.length; i < len; i++) {
			c.fillStyle = PURPLE;
			c.fillText(nlines[i].text, ts+thumbh+5, cy+nlines[i].height + 15);
		} 

		if (h < thumbh) {
			cy = ystart + thumbh;
		} else {
			cy = ystart + 20;
		}

		//console.log("cy="+cy);

		k = k + 1;
	});

} else {
	origami("#mrtCanvas").styles(".commented-white").
		shape(".commented-white").draw();
	origami("#mrtCanvas").styles(".commented-yellow").
		shape(".commented-yellow").draw();

	//writeTextLeft("Comment OFF!", 30,60, '#405500');
	cmt_tog = false;
	//c.clearRect(ts, ystart-5, 40+5+width, theight+20);
	c.clearRect(ts, ystart-5, 1700-ts, theight+20);
} 
