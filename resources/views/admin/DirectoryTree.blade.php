@extends("common.default")

@section("content")
<?php
$cf = new \App\lib\CommonFunction();
?>
<style>
    .select2-container{
        width: 100% !important;
    }
</style>
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
        <div class="equal_to_sidebar_mrgn">
            <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
            <button type="button" onclick="adddirectory(true)" class="btn btn-primary add-main-directory">Add Directory</button>
            <br><br>
            <b>Directory Management</b>
            <br><br>
            <ul id="tree3" class="ar_border" style="max-height:600px;overflow:auto;padding-left: 0px;">
            </ul>
        </div>
</div>
<div class="modal fade" id="directory-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="directoryModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="directoryForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title directory-title" id="directoryModalLabel">Add Directory</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Occupation" class="control-label">Occupation</label><br />
                        <select id="occupation">
                            @foreach($cf->getOccupation() as $ckey=>$cval)
                            <option value="{{$ckey}}">{{$cval}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="company" class="control-label">Company</label>
                        <input type="text" class="form-control" name="company" id="company" >
                    </div>
                    <div class="form-group">
                        <label for="business_reg_no" class="control-label">Business Reg No</label>
                        <input type="text" class="form-control" name="business_reg_no" id="business_reg_no" >
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <input type="text" class="form-control" name="address" id="address" >
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary directory-title">Add Directory</button>
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

    var getdirectory = function() {
        $.ajax({
            type: "GET",
            url: "{{ url('/admin/directory/get') }}",
            success: function(res) {
                loadTree(res);
            }
        });
    }

    getdirectory();

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
                    appendHtml += '<a href="" onclick="editdirectory()" class="custom-edit-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-pencil" style="color:#FFF;"></span></a>';
                    if (!object.nodes) {
                        appendHtml += '<a href="" onclick="removedirectory()" class="custom-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                    } else {
                        if (!object.nodes.length) {
                            appendHtml += '<a href="" onclick="removedirectory()" class="custom-remove-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                        };
                    }
                    appendHtml += '</span>';
                    $('#tree3 li.node-selected').append(appendHtml);
                }, 200);
            }
        });
    }

    // Load Categoty in Treeview

    // Add new directory modal display

    function adddirectory(isMain) {
        $(".maindirectory").hide();
        formSubmitType = "add";
        $("#directory-modal").modal('show');
        $(".directory-title").text("Add Directory");
        if (isMain) {
            $(".maindirectory").show();
            selectedNode = {};
        }
    }

    // edit directory modal display

    function editdirectory() {
        $(".maindirectory").hide();
        if (!selectedNode['data-directory-id']) {
            $(".maindirectory").show();
        };
        formSubmitType = "edit";
        $("#occupation_id").val(selectedNode.occupation_id);
        $("#company").val(selectedNode.company);
        $("#business_reg_no").val(selectedNode.business_reg_no);
        $("#name").val(selectedNode.name);
        $("#phone").val(selectedNode.phone);
        $("#address").val(selectedNode.address);
        $("#email").val(selectedNode.email);
        $("#directory-modal").modal('show');
        $(".directory-title").text("Edit Directory");
    }

    // remove directory

    function removedirectory() {

        if (confirm('Are you sure you want to remove directory?')) {

            if (selectedNode) {

                if (selectedNode.nodes) {
                    delete selectedNode.nodes;
                }

                // remove directory form database
                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/directory/remove') }}",
                    data: selectedNode,
                    success: function(res) {
                        selectedNode = null;
                        formSubmitType = null;
                        getdirectory();
                        $(".success-msg").fadeIn();
                        $(".success-msg").text("Directory successfully removed.");
                        $(".success-msg").fadeOut(4000);
                        return false;
                    }
                });
            }
        }
    }

    // submit add or edit directory form
    $("#directoryForm").on("submit", function(event) {

        if (selectedNode) {

            if (!formSubmitType) {
                return false;
            };

            var url = "{{ url('/admin/directory/add') }}";
            if (formSubmitType == 'edit') {
                url = "{{ url('/admin/directory/edit') }}";
            }

            if (selectedNode.nodes) {
                delete selectedNode.nodes;
            }

            var formData = new FormData();;

            formData.append('occupation_id', $("#occupation").val());
            formData.append('company', $("#company").val());
            formData.append('business_reg_no', $("#business_reg_no").val());
            formData.append('name', $("#name").val());
            formData.append('phone', $("#phone").val());
            formData.append('address', $("#address").val());
            formData.append('email', $("#email").val());

            if (selectedNode['data-directory-id']) {
                formData.append('data-directory-id', selectedNode['data-directory-id']);
            }

            // add or edit directory
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR) {
                    document.getElementById("directoryForm").reset();
                    selectedNode = null;
                    formData = null;
                    logoFile = null;
                    getdirectory();
                    $("#directory-modal").modal('hide');
                    $(".success-msg").fadeIn();
                    if (formSubmitType == 'edit') {
                        $(".success-msg").text("Directory successfully updated.");
                    } else {
                        $(".success-msg").text("Directory successfully added.");
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

    $('#directory-modal').on('hidden.bs.modal', function(e) {
        selectedNode = null;
        formSubmitType = null;
        document.getElementById("directoryForm").reset();
    });

</script>
@stop
