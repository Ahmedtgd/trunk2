@extends("common.default")

@section("content")
    <div class="container" style="margin-top:30px;">
		@include('admin/panelHeading')
		<br>
            <div style="margin-left:0;margin-right:0"
				class="equal_to_sidebar_mrgn row">
                <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
                <h2 style="display:inline;padding-left:15px">
					Category Management</h2>
                <button type="button" onclick="addCategory(true)"
				class="btn btn-primary add-main-category col-md-offset-1"
				style="margin-bottom:10px">Add Category</button>
                <ul id="tree3" class="ar_border"
				style="max-height:600px;overflow:auto;padding-left:0">
                </ul>
            </div>
    </div>
    <div class="modal fade" id="cat-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="categoryForm" action="#" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title category-title" id="categoryModalLabel">Add</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="categoryName" class="control-label">System Name:</label>
                            <input type="text" class="form-control" name="categoryName" id="categoryName" required>
                        </div>
                        <div class="form-group">
                            <label for="categoryDescription" class="control-label">Public Description:</label>
                            <input type="text" class="form-control" name="categoryDescription" id="categoryDescription" required>
                        </div>
                        <div class="mainCategory" style="display:none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="floor" class="control-label">Floor:</label>
                                        <div class="input-group">
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-default btn-number" data-type="minus" data-field="floor">
                                                  <span class="glyphicon glyphicon-minus"></span>
                                              </button>
                                          </span>
                                          <input type="text" name="floor" class="form-control" value="1" id="floor">
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="floor">
                                                  <span class="glyphicon glyphicon-plus"></span>
                                              </button>
                                          </span>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="color" class="control-label">Colour:</label>

                                      <div class="input-group">
                                          <span class="input-group-btn">
                                              <button type="button" class="btn btn-default">
                                                  <span>#</span>
                                              </button>
                                          </span>
                                          <input type="text" name="color" id="color" class="form-control">
                                          <span class="input-group-btn">
                                            <button type="button" class="btn btn-default">
                                                <span>Go</span>
                                                <span class="glyphicon glyphicon-ok"></span>
                                              </button>
                                          </span>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <img src="" id="categoryImage" width="100%" height="150" style="background-color: rgba(204, 204, 204, 0.31);">
                                <div class="form-group">
                                    <label for="categoryLogo" class="control-label">Logo</label>
                                    <input type="file" name="categoryLogo" id="categoryLogo">
                                </div>
                            </div>
                            <div class="col-md-6 mainCategory" style="display:none;">
                                <img src="" id="categoryGreenImage" width="100%" height="150">
                                <div class="form-group">
                                    <label for="categoryGreenLogo" class="control-label">Logo Green</label>
                                    <input type="file" name="categoryGreenLogo" id="categoryGreenLogo">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<input type="hidden" id="maxcat" value="1" />
	<input type="hidden" id="addcat" value="1" />
	<input type="hidden" id="editcat" value="0" />
<script src="{{ URL::asset('js/bootstrap-treeview.js')}}"></script>
<script type="text/javascript">

    var treeData = [];
    var selectedNode = null;
    var formSubmitType = null;

    $(function(){
        $('#color').ColorPicker({
            onChange: function (hsb, hex, rgb) {
                $('#color').val(hex);
            }
        });

		$('#floor').keyup(function(e){
			var maximum = parseInt($("#maxcat").val()) + 1;
			if(parseInt($("#editcat").val()) == 1){
				var maximum = maximum -1;
			}
			var input = $("input[name='floor']");
            var currentVal = parseInt(input.val());
			
			if (currentVal >= maximum || currentVal < 1) {
				input.val("1");
            }
		});
		
        $('.btn-number').click(function(e){
            var type = $(this).attr('data-type');
            var input = $("input[name='floor']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if(type == 'minus') {
                    if (currentVal == 1) {
                        return false;
                    }
                    input.val(currentVal - 1)

                } else if(type == 'plus') {
					var maximum = parseInt($("#maxcat").val()) + 1;
					if(parseInt($("#editcat").val()) == 1){
						var maximum = maximum -1;
					}
					
					if (currentVal >= maximum) {
                        return false;
                    }					
                    input.val(currentVal + 1);
                }
            } else {
                input.val(0);
            }
        });
    });

    var getCategory = function() {
        $.ajax({
        type: "GET",
            url: "{{ url('/admin/category/get') }}",
            success: function(res) {
                loadTree(res);
            }
        });
    }

    getCategory();
	
    var getCategoryNum = function() {
        $.ajax({
        type: "GET",
            url: "{{ url('/admin/category/getnum') }}",
            success: function(res) {
                $("#maxcat").val(res);
            }
        });
    }

    getCategoryNum();	

    var loadTree = function(treeData) {
        $('#tree3').treeview('remove');
        $('#tree3').treeview({
            levels: 1,
            data: treeData,
            nodeUnselected: function(event, object) {
                selectedNode = null;
                formSubmitType = null;
            },
            onNodeSelected: function(event, object) {

                selectedNode = object;
                $('#tree3 li .custom-options').remove();

                setTimeout(function() {
                    var appendHtml = '<span class="pull-right custom-options">';
                    if (!object['data-category-3-id']) {
                        appendHtml += '<a href="" onclick="addCategory()" class="custom-add-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-plus" style="color:#FFF;"></span></a>';
                    }
                    appendHtml += '<a href="" onclick="editCategory()" class="custom-edit-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-pencil" style="color:#FFF;"></span></a>';
                    if (!object.nodes) {
                        appendHtml += '<a href="" onclick="removeCategory()" class="custom-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                    } else {
                        if (!object.nodes.length) {
                            appendHtml += '<a href="" onclick="removeCategory()" class="custom-remove-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                        };
                    }
                    appendHtml += '</span>';
                    $('#tree3 li.node-selected').append(appendHtml);
                }, 200);
            }
        });
    }

    // Load Categoty in Treeview

    // Add new category modal display

    function addCategory(isMain) {
		$("#addcat").val(1);
		$("#editcat").val(0);
        $(".mainCategory").hide();
        $("label[for='categoryLogo']").text('Logo');
        formSubmitType = "add";
        $("#cat-modal").modal('show');
        $(".category-title").text("Add Category");
        if (isMain) {
            $("label[for='categoryLogo']").text('Logo White');
            $(".mainCategory").show();
            $('img#categoryImage').hide();
            $('img#categoryGreenImage').hide();
            selectedNode = {};
        } else {
			 $(".category-title").text("Add SubCategory");
		}
    }

    // edit category modal display

    function editCategory() {
		$("#addcat").val(0);
		$("#editcat").val(1);		
        $(".mainCategory").hide();
        $("label[for='categoryLogo']").text('Logo');
        if (!selectedNode['data-category-1-id']) {
            $("label[for='categoryLogo']").text('Logo White');
            $(".mainCategory").show();
            if (selectedNode.floor) {
                $("#floor").val(selectedNode.floor);
            };
            if (selectedNode.color) {
                var tempColor = selectedNode.color.substr(1);
                $("#color").val(tempColor);
            };
			$(".category-title").text("Edit Category");
        }else {
			$(".category-title").text("Edit SubCategory");
		}
        formSubmitType = "edit";
        if (selectedNode.logo) {
            $('img#categoryImage').show();
            $('img#categoryImage').attr('src', selectedNode.logo);
        } else {
            $('img#categoryImage').hide();
        }
        if (selectedNode.logoGreen) {
            $('img#categoryGreenImage').show();
            $('img#categoryGreenImage').attr('src', selectedNode.logoGreen);
        } else {
            $('img#categoryGreenImage').hide();
        }
        $("#categoryName").val(selectedNode.name);
        $("#categoryDescription").val(selectedNode.desc);
        $("#cat-modal").modal('show');
        
    }

    // remove category

    function removeCategory() {

        if (confirm('Are you sure you want to remove category?')) {

            if (selectedNode) {

                if (selectedNode.nodes) {
                    delete selectedNode.nodes;
                }

                // remove category form database
                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/category/remove') }}",
                    data: selectedNode,
                    success: function(res) {
                        selectedNode = null;
                        formSubmitType = null;
                        getCategory();
                        $(".success-msg").fadeIn();
                        $(".success-msg").text("Category successfully removed.");
                        $(".success-msg").fadeOut(4000);
						getCategory();
						getCategoryNum();
                        return false;
                    }
                });
            }
        }
    }

    var logoFile = null;
    var greenLogoFile = null;
    $("input#categoryLogo").on('change', function(event) {
        logoFile = event.target.files;
    });

    $("input#categoryGreenLogo").on('change', function(event) {
        greenLogoFile = event.target.files;
    });

    // submit add or edit category form
    $("#categoryForm").on("submit", function(event) {

        if (selectedNode) {

            if (!formSubmitType) {
                return false;
            };

            var url = "{{ url('/admin/category/add') }}";
            if (formSubmitType == 'edit') {
                url = "{{ url('/admin/category/edit') }}";
            }

            if (selectedNode.nodes) {
                delete selectedNode.nodes;
            }

            var formData = new FormData();;

            if (logoFile) {
                formData.append('logo', logoFile[0]);
            }

            if (greenLogoFile) {
                formData.append('greenLogo', greenLogoFile[0]);
            }

            formData.append('categoryName', $("#categoryName").val());
            formData.append('categoryDescription', $("#categoryDescription").val());

            if ($("#floor").val()) {
                formData.append('floor', $("#floor").val());
            };

            if ($("#color").val()) {
                formData.append('color', '#'+$("#color").val());
            };

            if (selectedNode['data-category-id']) {
                formData.append('data-category-id', selectedNode['data-category-id']);
            }
            if (selectedNode['data-category-1-id']) {
                formData.append('data-category-1-id', selectedNode['data-category-1-id']);
            }
            if (selectedNode['data-category-2-id']) {
                formData.append('data-category-2-id', selectedNode['data-category-2-id']);
            }
            if (selectedNode['data-category-3-id']) {
                formData.append('data-category-3-id', selectedNode['data-category-3-id']);
            }

            // add or edit category
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR) {
                    document.getElementById("categoryForm").reset();
                    selectedNode = null;
                    formData = null;
                    logoFile = null;
                    getCategory();
                    $("#cat-modal").modal('hide');
                    $(".success-msg").fadeIn();
                    if (formSubmitType == 'edit') {
                        $(".success-msg").text("Category successfully updated.");
                    } else {
                        $(".success-msg").text("Category successfully added.");
                    }
                    $(".success-msg").fadeOut(4000);
                    formSubmitType = null;
					getCategory();
					getCategoryNum();
                    return false;
                }
            });
        };
        return false;
        event.preventDefault();
    });

    $('#cat-modal').on('hidden.bs.modal', function(e) {
        selectedNode = null;
        formSubmitType = null;
        document.getElementById("categoryForm").reset();
    });

</script>
@stop
