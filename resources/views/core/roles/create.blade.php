<div class="modal fade" id="modalCreateRole" tabindex="-1" role="dialog" aria-labelledby="modalCreateRoleLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" id="formRoleCreate" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateRoleLabel">Create Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-12">
                        <label for="name" class="mb-1">Name</label>
                        <input type="text" name="name" placeholder="Name" class="form-control" id="name">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="permissions" class="mb-1">Permission</label>
                        <select name="permissions[]" id="permissions" class="form-control select2" multiple></select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="menus" class="mb-1">Menus</label>
                        <select name="menus[]" id="menus" class="form-control select2" multiple>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitData" onclick="$(this).submit()">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $('#modalCreateRole').on('show.bs.modal', function() {

            ajaxRequest({
                url: `/apis/permissions`,
            }).done((permissions) => {
                setDataSelect({
                    tagid: '#permissions',
                    modalid: '#modalCreateRole',
                    data: permissions.data.map((item) => {
                        return {
                            id: item.name,
                            text: item.name,
                        }
                    }),
                    placeholder: 'Select Permissions',
                })
            })

            ajaxRequest({
                url: `/apis/menus`,
            }).done((menus) => {
                setDataSelect({
                    tagid: '#menus',
                    modalid: '#modalCreateRole',
                    data: menus.data.map((item) => {
                        return {
                            id: item.id,
                            text: item.menu_name,
                        }
                    }),
                    placeholder: 'Select Menus',
                })
            })

            $('#formRoleCreate').ajaxForm({
                url: '/core/roles',
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
                    $('#modalCreateRole').modal('toggle')
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