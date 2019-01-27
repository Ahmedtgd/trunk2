@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
        <div class="equal_to_sidebar_mrgn">
            <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
            <button type="button" onclick="addfeedback(true)" class="btn btn-primary add-main-feedback">Add Feedback</button>
            <br><br>
            <b>Feedback Management</b>
            <br><br>
            <ul id="tree3" class="ar_border" style="max-height:600px;overflow:auto;padding-left: 0px;">
            </ul>
        </div>
</div>
<div class="modal fade" id="feedback-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="feedbackForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title feedback-title" id="feedbackModalLabel">Add Feedback</h4>
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
                    <div class="form-group">
                        <label for="company_name" class="control-label">Company</label>
                        <input type="text" class="form-control" name="company_name" id="company_name" required>
                    </div>
                    <div class="form-group">
                        <label for="company_phone" class="control-label">Company Phone</label>
                        <input type="text" class="form-control" name="company_phone" id="company_phone" >
                    </div>
                    <div class="form-group">
                        <label for="company_email" class="control-label">Company Email</label>
                        <input type="email" class="form-control" name="company_email" id="company_email">
                    </div>
                    <div class="form-group">
                        <label for="company_address" class="control-label">Company Address</label>
                        <input type="text" class="form-control" name="company_address" id="company_address" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary feedback-title">Add Feedback</button>
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

    var getfeedback = function() {
        $.ajax({
            type: "GET",
            url: "{{ url('/admin/feedback/get') }}",
            success: function(res) {
                loadTree(res);
            }
        });
    }

    getfeedback();

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
                    appendHtml += '<a href="" onclick="editfeedback()" class="custom-edit-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-pencil" style="color:#FFF;"></span></a>';
                    if (!object.nodes) {
                        appendHtml += '<a href="" onclick="removefeedback()" class="custom-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                    } else {
                        if (!object.nodes.length) {
                            appendHtml += '<a href="" onclick="removefeedback()" class="custom-remove-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                        };
                    }
                    appendHtml += '</span>';
                    $('#tree3 li.node-selected').append(appendHtml);
                }, 200);
            }
        });
    }

    // Load Categoty in Treeview

    // Add new feedback modal display

    function addfeedback(isMain) {
        $(".mainfeedback").hide();
        formSubmitType = "add";
        $("#feedback-modal").modal('show');
        $(".feedback-title").text("Add Feedback");
        if (isMain) {
            $(".mainfeedback").show();
            selectedNode = {};
        }
    }

    // edit feedback modal display

    function editfeedback() {
        $(".mainfeedback").hide();
        if (!selectedNode['data-feedback-id']) {
            $(".mainfeedback").show();
        };
        formSubmitType = "edit";
        $("#name").val(selectedNode.name);
        $("#company_name").val(selectedNode.company_name);
        $("#company_phone").val(selectedNode.company_phone);
        $("#company_email").val(selectedNode.company_email);
        $("#company_address").val(selectedNode.company_address);
        $("#phone").val(selectedNode.phone);
        $("#email").val(selectedNode.email);
        $("#remarks").val(selectedNode.remarks);
        $("#address").val(selectedNode.address);
        $("#feedback-modal").modal('show');
        $(".feedback-title").text("Edit Feedback");
    }

    // remove feedback

    function removefeedback() {

        if (confirm('Are you sure you want to remove feedback?')) {

            if (selectedNode) {

                if (selectedNode.nodes) {
                    delete selectedNode.nodes;
                }

                // remove feedback form database
                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/feedback/remove') }}",
                    data: selectedNode,
                    success: function(res) {
                        selectedNode = null;
                        formSubmitType = null;
                        getfeedback();
                        $(".success-msg").fadeIn();
                        $(".success-msg").text("Feedback successfully removed.");
                        $(".success-msg").fadeOut(4000);
                        return false;
                    }
                });
            }
        }
    }

    // submit add or edit feedback form
    $("#feedbackForm").on("submit", function(event) {

        if (selectedNode) {

            if (!formSubmitType) {
                return false;
            };

            var url = "{{ url('/admin/feedback/add') }}";
            if (formSubmitType == 'edit') {
                url = "{{ url('/admin/feedback/edit') }}";
            }

            if (selectedNode.nodes) {
                delete selectedNode.nodes;
            }

            var formData = new FormData();;

            formData.append('name', $("#name").val());
            formData.append('company_name', $("#company_name").val());
            formData.append('company_phone', $("#company_phone").val());
            formData.append('company_email', $("#company_email").val());
            formData.append('company_address', $("#company_address").val());
            formData.append('phone', $("#phone").val());
            formData.append('remarks', $("#remarks").val());
            formData.append('address', $("#address").val());
            formData.append('email', $("#email").val());

            if (selectedNode['data-feedback-id']) {
                formData.append('data-feedback-id', selectedNode['data-feedback-id']);
            }

            // add or edit feedback
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR) {
                    document.getElementById("feedbackForm").reset();
                    selectedNode = null;
                    formData = null;
                    logoFile = null;
                    getfeedback();
                    $("#feedback-modal").modal('hide');
                    $(".success-msg").fadeIn();
                    if (formSubmitType == 'edit') {
                        $(".success-msg").text("Feedback successfully updated.");
                    } else {
                        $(".success-msg").text("Feedback successfully added.");
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

    $('#feedback-modal').on('hidden.bs.modal', function(e) {
        selectedNode = null;
        formSubmitType = null;
        document.getElementById("feedbackForm").reset();
    });

</script>
@stop
