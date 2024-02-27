<div class="modal fade" id="modalUpdateRole" tabindex="-1" role="dialog" aria-labelledby="modalUpdateRoleLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" id="formRoleUpdate" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdateRoleLabel">Update Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-12">
                        <label for="name" class="mb-1">Name</label>
                        <input type="text" name="name" placeholder="Name" class="form-control" id="e_name">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="permissions" class="mb-1">Permission</label>
                        <select name="permissions[]" id="e_permissions" class="form-control select2" multiple></select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="e_menus" class="mb-1">Menus</label>
                        <select name="menus[]" id="e_menus" class="form-control select2" multiple>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" id="updateData" onclick="$(this).submit()">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $('#modalUpdateRole').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/apis/roles/${id}`,
            }).done((roles) => {
                $('#e_name').val(roles.data.name)

                ajaxRequest({
                    url: `/apis/permissions`,
                }).done((permissions) => {
                    setDataSelect({
                        tagid: '#e_permissions',
                        modalid: '#modalUpdateRole',
                        data: permissions.data.map((item) => {
                            return {
                                id: item.name,
                                text: item.name,
                            }
                        }),
                        dataSelected: roles.data.relationship.permissions.map((item) => {
                            return item.name
                        }),
                        placeholder: 'Select Permissions',
                    })
                })

                ajaxRequest({
                    url: `/apis/menus`,
                }).done((menus) => {
                    setDataSelect({
                        tagid: '#e_menus',
                        modalid: '#modalUpdateRole',
                        data: menus.data.map((item) => {
                            return {
                                id: item.id,
                                text: item.menu_name,
                            }
                        }),
                        dataSelected: roles.data.relationship.menus.map((item) => {
                            return item.id
                        }),
                        placeholder: 'Select Menus',
                    })
                })
            })

            $('#formRoleUpdate').ajaxForm({
                url: `/core/roles/${id}`,
                type: 'POST',
                resetForm: true,
                beforeSubmit: function(formData) {
                    var formSerialize = $.param(formData);
                    return true;
                },
                success: function(result) {
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })

                    $('#role-table').DataTable().ajax.reload()
                    $('#modalUpdateRole').modal('toggle')
                },
                error: function(errors) {
                    Toast.fire({
                        icon: 'error',
                        title: errors.responseJSON.message,
                    })
                }
            });
        })
    })
</script>