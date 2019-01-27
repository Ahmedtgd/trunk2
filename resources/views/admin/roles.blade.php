@extends("common.default")

@section("content")
    <div class="container" style="margin-top:30px;">
        @include('admin/panelHeading')
            <div class="equal_to_sidebar_mrgn">
                <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
                <button type="button" onclick="addRole(true)" class="btn btn-primary create-role-btn">Create Role</button>
                <br><br>
                <b>Role Management</b>
                <br><br>
                <div id="rolesMgmt">
                    <ul id="tree3" class="ar_border" style="max-height:600px;overflow:auto;padding-left: 0px;">
                    </ul>
                    <!--table class="table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table-->
                </div>
            </div>
    </div>
    <div class="modal fade" id="role-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="roleForm" action="#" enctype="multipart/form-data" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title role-title" id="addRoleModalLabel">Create Role</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="roleName" class="control-label">Name:</label>
                            <input type="text" class="form-control" name="roleName" id="roleName" required>
                        </div>
                        <div class="form-group">
                            <label for="roleDescription" class="control-label">Description:</label>
                            <input type="text" class="form-control" name="roleDescription" id="roleDescription" required>
                        </div>
                        <div class="form-group">
                            <label for="roleSlug" class="control-label">Slug:</label>
                            <input type="text" class="form-control" name="roleSlug" id="roleSlug" required>
                        </div>
                        <div class="form-group">
                            <label for="permissions" class="control-label">Permissions:</label>
                            <br>
                            <label class="radio-inline">
                                <input type="radio" name="permissions" id="read" value="1"> Read
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="permissions" id="write" value="2"> Write
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="permissions" id="readWrite" value="3"> Read / Write
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary role-title">Create Role</button>
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


        var getRoles = function() {
            $.ajax({
                type: "GET",
                url: "{{ url('/admin/roles/get') }}",
                success: function(data) {
                    loadTree(data);
                }
            });
        }

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
                        appendHtml += '<a href="" onclick="editRole()" class="custom-edit-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-pencil" style="color:#FFF;"></span></a>';
                        if (!object.nodes) {
                            appendHtml += '<a href="" onclick="removeRole()" class="custom-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                        } else {
                            if (!object.nodes.length) {
                                appendHtml += '<a href="" onclick="removeRole()" class="custom-remove-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                            };
                        }
                        appendHtml += '</span>';
                        $('#tree3 li.node-selected').append(appendHtml);
                    }, 200);
                }
            });
        }

       /*---------------------------*/
        // Add new Role modal display
        function addRole(isMain) {
            $(".maindirectory").hide();
            formSubmitType = "add";
            $("#role-modal").modal('show');
            $(".role-title").text("Add Role");
            if (isMain) {
                $(".maindirectory").show();
                selectedNode = {};
            }
        }

        // edit Role modal display
        function editRole() {
            $(".maindirectory").hide();
            if (!selectedNode['data-role-id']) {
                $(".maindirectory").show();
            };

            formSubmitType = "edit";

            $("#roleName").val(selectedNode.name);
            $("#roleSlug").val(selectedNode.slug);
            $("#roleDescription").val(selectedNode.description);

            if(selectedNode.permissions != null){
                if(selectedNode.permissions.hasOwnProperty('read'))
                    $("input[name='permissions']#read").prop( "checked", true );

                if(selectedNode.permissions.hasOwnProperty('write'))
                    $("input[name='permissions']#write").prop( "checked", true );

                if(selectedNode.permissions.hasOwnProperty('read') && selectedNode.permissions.hasOwnProperty('write'))
                    $("input[name='permissions']#readWrite").prop( "checked", true );
            }

            $("#role-modal").modal('show');
            $(".role-title").text("Edit Role");
        }

        // remove Role
        function removeRole() {
            if (confirm('Are you sure you want to remove role: '+ selectedNode.description +' ?')) {

                if (selectedNode) {
                    if (selectedNode.nodes) {
                        delete selectedNode.nodes;
                    }

                    // remove Role form database
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/admin/roles/remove') }}",
                        data: selectedNode,
                        success: function(res) {
                            selectedNode = null;
                            formSubmitType = null;
                            getRoles();
                            $(".success-msg").fadeIn();
                            $(".success-msg").text("Role successfully removed.");
                            $(".success-msg").fadeOut(4000);
                            return false;
                        }
                    });
                }
            }
        }

        getRoles();

        // submit add or edit Role form
        $("#roleForm").on("submit", function(event) {

            if (selectedNode) {

                if (!formSubmitType) {
                    return false;
                };

                var url = "{{ url('/admin/roles/add') }}";
                if (formSubmitType == 'edit') {
                    url = "{{ url('/admin/roles/edit') }}";
                }

                if (selectedNode.nodes) {
                    delete selectedNode.nodes;
                }

                var formData = new FormData();;
                formData.append('roleName', $("#roleName").val());
                formData.append('roleSlug', $("#roleSlug").val());
                formData.append('roleDescription', $("#roleDescription").val());
                formData.append('permissions', $("input[name='permissions']:checked").val());

                if (selectedNode['data-role-id']) {
                    formData.append('data-role-id', selectedNode['data-role-id']);
                }

                // add or edit Role
                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    cache: false,
                    dataType: 'json',
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function(data, textStatus, jqXHR) {
                        document.getElementById("roleForm").reset();
                        selectedNode = null;
                        formData = null;
                        logoFile = null;
                        getRoles();
                        $("#role-modal").modal('hide');
                        $(".success-msg").fadeIn();
                        if (formSubmitType == 'edit') {
                            $(".success-msg").text("Role successfully updated.");
                        } else {
                            $(".success-msg").text("Role successfully added.");
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

        $('#role-modal').on('hidden.bs.modal', function(e) {
            selectedNode = null;
            formSubmitType = null;
            document.getElementById("roleForm").reset();
        });


    </script>
@stop
