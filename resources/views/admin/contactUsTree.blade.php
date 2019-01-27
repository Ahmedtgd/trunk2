@extends("common.default")

@section("content")

<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
        <div class="equal_to_sidebar_mrgn">
            <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
            <button type="button" onclick="addcontactUs(true)" class="btn btn-primary add-main-contactUs">Add Contact Us</button>
            <br><br>
            <b>Contact Us Management</b>
            <br><br>
            <ul id="tree3" class="ar_border" style="max-height:600px;overflow:auto;padding-left: 0px;">
            </ul>
        </div>
</div>
<div class="modal fade" id="contactUs-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="contactUsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="contactUsForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title contactUs-title" id="contactUsModalLabel">Add Contact Us</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks" class="control-label">Remarks</label>
                        <input type="text" class="form-control" name="remarks" id="remarks" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary contactUs-title">Add Contact Us</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/bootstrap-treeview.js')}}"></script>
<script type="text/javascript">

    var treeData = [];
    var selectedNode = null;
    var formSubmitType = null;

    $(function(){
        $('.btn-number').click(function(e){
            var type = $(this).attr('data-type');
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if(type == 'minus') {
                    if (currentVal == 0) {
                        return false;
                    }
                    input.val(currentVal - 1)

                } else if(type == 'plus') {
                    input.val(currentVal + 1);
                }
            } else {
                input.val(0);
            }
        });
    });

    var getcontactUs = function() {
        $.ajax({
            type: "GET",
            url: "{{ url('/admin/contactus/get') }}",
            success: function(res) {
                loadTree(res);
            }
        });
    }

    getcontactUs();

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
                    appendHtml += '<a href="" onclick="editcontactUs()" class="custom-edit-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-pencil" style="color:#FFF;"></span></a>';
                    if (!object.nodes) {
                        appendHtml += '<a href="" onclick="removecontactUs()" class="custom-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                    } else {
                        if (!object.nodes.length) {
                            appendHtml += '<a href="" onclick="removecontactUs()" class="custom-remove-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                        };
                    }
                    appendHtml += '</span>';
                    $('#tree3 li.node-selected').append(appendHtml);
                }, 200);
            }
        });
    }

    // Load Categoty in Treeview

    // Add new contactUs modal display

    function addcontactUs(isMain) {
        $(".maincontactUs").hide();
        formSubmitType = "add";
        $("#contactUs-modal").modal('show');
        $(".contactUs-title").text("Add Contact Us");
        if (isMain) {
            $(".maincontactUs").show();
            selectedNode = {};
        }
    }

    // edit contactUs modal display

    function editcontactUs() {
        $(".maincontactUs").hide();
        if (!selectedNode['data-contactUs-id']) {
            $(".maincontactUs").show();
        };
        formSubmitType = "edit";
        $("#name").val(selectedNode.name);
        $("#phone").val(selectedNode.phone);
        $("#email").val(selectedNode.email);
        $("#remarks").val(selectedNode.remarks);
        $("#contactUs-modal").modal('show');
        $(".contactUs-title").text("Edit Contact Us");
    }

    // remove contactUs

    function removecontactUs() {

        if (confirm('Are you sure you want to remove contactUs?')) {

            if (selectedNode) {

                if (selectedNode.nodes) {
                    delete selectedNode.nodes;
                }

                // remove contactUs form database
                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/contactus/remove') }}",
                    data: selectedNode,
                    success: function(res) {
                        selectedNode = null;
                        formSubmitType = null;
                        getcontactUs();
                        $(".success-msg").fadeIn();
                        $(".success-msg").text("Contact Us successfully removed.");
                        $(".success-msg").fadeOut(4000);
                        return false;
                    }
                });
            }
        }
    }

    // submit add or edit contactUs form
    $("#contactUsForm").on("submit", function(event) {

        if (selectedNode) {

            if (!formSubmitType) {
                return false;
            };

            var url = "{{ url('/admin/contactus/add') }}";
            if (formSubmitType == 'edit') {
                url = "{{ url('/admin/contactus/edit') }}";
            }

            if (selectedNode.nodes) {
                delete selectedNode.nodes;
            }

            var formData = new FormData();;

            formData.append('name', $("#name").val());
            formData.append('phone', $("#phone").val());
            formData.append('remarks', $("#remarks").val());
            formData.append('email', $("#email").val());

            if (selectedNode['data-contactUs-id']) {
                formData.append('data-contactUs-id', selectedNode['data-contactUs-id']);
            }

            // add or edit contactUs
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR) {
                    document.getElementById("contactUsForm").reset();
                    selectedNode = null;
                    formData = null;
                    logoFile = null;
                    getcontactUs();
                    $("#contactUs-modal").modal('hide');
                    $(".success-msg").fadeIn();
                    if (formSubmitType == 'edit') {
                        $(".success-msg").text("Contact Us successfully updated.");
                    } else {
                        $(".success-msg").text("Contact Us successfully added.");
                    }
                    $(".success-msg").fadeOut(4000);
                    formSubmitType = null;
                    return false;
                }
            });
        };
        return false;
        event.preventDefault();
    });

    $('#contactUs-modal').on('hidden.bs.modal', function(e) {
        selectedNode = null;
        formSubmitType = null;
        document.getElementById("contactUsForm").reset();
    });

</script>
@stop
