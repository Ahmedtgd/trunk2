/* ========================================================================
 * bootstrap-spin - v1.0
 * https://github.com/wpic/bootstrap-spin
 * ========================================================================
 * Copyright 2014 WPIC, Hamed Abdollahpour
 *
 * ========================================================================
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================================
 */

(function ($) {
    $.fn.bootstrapNumber = function (options) {

        var settings = $.extend({
            upClass: 'default',
            downClass: 'default',
            center: true
        }, options);

        return this.each(function (e) {
            var self = $(this);
            var clone = self.clone();

            var min = self.attr('min');
            var max = self.attr('max');

            function setText(n) {
                if ((min && n < min) || (max && n > max)) {
                    return false;
                }
				$(".pricesn").trigger("change");
                clone.focus().val(n);
                return true;
            }

            var group = $("<div class='input-group'></div>");
            var down = $("<button type='button'><span class='glyphicon glyphicon-minus'></span></button>").attr('class', 'btn btn-css btn-' + settings.downClass).click(function () {
                setText(parseInt(clone.val()) - 1);
			//	console.log(clone.attr("rel"));
				var rel = clone.attr("rel");
				var qty = $("#qty" + rel).val();
				var counter = 1;
			//	console.log(rel);
				$(".wprice" + rel).each(function() {				
					var funit = $("#funit" + rel + "-" + counter).val();
					var unit = $("#unit" + rel + "-" + counter).val();
					var wprice = $("#wprice" + rel + "-" + counter).val();
				//	console.log(wprice);
				//	console.log(unit);
				//	console.log(funit);
					counter++;
					if(parseInt(qty) >= parseInt(funit) && parseInt(qty) <= parseInt(unit)){
					//	qty = $("#qty" + rel).val();
					//	console.log(qty);
						$(".mprice" + rel).text(js_number_format((wprice * (parseInt(qty))),2,".",""));
					}
				});				
            });
            var up = $("<button type='button'><span class='glyphicon glyphicon-plus'></span></button>").attr('class', 'btn btn-css btn-' + settings.upClass).click(function () {
                setText(parseInt(clone.val()) + 1);
			//	console.log(clone.attr("rel"));
				var rel = clone.attr("rel");
				var qty = $("#qty" + rel).val();
				var counter = 1;
			//	console.log(rel);
				$(".wprice" + rel).each(function() {				
					var funit = $("#funit" + rel + "-" + counter).val();
					var unit = $("#unit" + rel + "-" + counter).val();
					var wprice = $("#wprice" + rel + "-" + counter).val();
				//	console.log(wprice);
				//	console.log(unit);
				//	console.log(funit);
					counter++;
					if(parseInt(qty) >= parseInt(funit) && parseInt(qty) <= parseInt(unit)){
					//	qty = $("#qty" + rel).val();
					//	console.log(qty);
						$(".mprice" + rel).text(js_number_format((wprice * (parseInt(qty))),2,".",""));
					}
				});
            });
            $("<span class='input-group-btn'></span>").append(up).appendTo(group);
            clone.appendTo(group);
            if (clone) {
                clone.css('text-align', 'center');
            }
            $("<span class='input-group-btn'></span>").append(down).appendTo(group);

            // remove spins from original
            clone.prop('type', 'text').keydown(function (e) {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					(e.keyCode == 65 && e.ctrlKey === true) ||
					(e.keyCode >= 35 && e.keyCode <= 39)) {
                    return;
                }
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }

                var c = String.fromCharCode(e.which);
                var n = parseInt(clone.val() + c);

                //if ((min && n < min) || (max && n > max)) {
                //    e.preventDefault();
                //}
            });

            clone.prop('type', 'text').blur(function (e) {
                var c = String.fromCharCode(e.which);
                var n = parseInt(clone.val() + c);
                if ((min && n < min)) {
                    setText(min);
                }
                else if (max && n > max) {
                    setText(max);
                }
				var rel = clone.attr("rel");
				var qty = $("#qty" + rel).val();
				var counter = 1;
			//	console.log(rel);
				$(".wprice" + rel).each(function() {				
					var funit = $("#funit" + rel + "-" + counter).val();
					var unit = $("#unit" + rel + "-" + counter).val();
					var wprice = $("#wprice" + rel + "-" + counter).val();
				//	console.log(wprice);
				//	console.log(unit);
				//	console.log(funit);
					counter++;
					if(parseInt(qty) >= parseInt(funit) && parseInt(qty) <= parseInt(unit)){
					//	qty = $("#qty" + rel).val();
					//	console.log(qty);
						$(".mprice" + rel).text(js_number_format((wprice * (parseInt(qty))),2,".",""));
					}
				});
            });


            self.replaceWith(group);
        });
    };
}(jQuery));
	