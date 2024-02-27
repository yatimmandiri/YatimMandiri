<div class="modal fade" id="modalUpdatePermission" tabindex="-1" role="dialog" aria-labelledby="modalUpdatePermissionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" id="formPermissionUpdate" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdatePermissionLabel">Update Data</h5>
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
                        <label for="roles" class="mb-1">Roles</label>
                        <select name="roles[]" id="e_roles" class="form-control select2" multiple></select>
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
        $('#modalUpdatePermission').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/apis/permissions/${id}`,
            }).done((permissions) => {
                $('#e_name').val(permissions.data.name)

                ajaxRequest({
                    url: `/apis/roles`,
                }).done((roles) => {
                    setDataSelect({
                        tagid: '#e_roles',
                        modalid: '#modalUpdatePermission',
                        data: roles.data.map((item) => {
                            return {
                                id: item.name,
                                text: item.name,
                            }
                        }),
                        dataSelected: permissions.data.relationship.roles.map((item) => {
                            return item.name
                        }),
                        placeholder: 'Select Role',
                    })
                })
            })

            $('#formPermissionUpdate').ajaxForm({
                url: `/core/permissions/${id}`,
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

                    $('#permission-table').DataTable().ajax.reload()
                    $('#modalUpdatePermission').modal('toggle')
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