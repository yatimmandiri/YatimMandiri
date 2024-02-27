<div class="modal fade" id="modalInfoRole" tabindex="-1" role="dialog" aria-labelledby="modalInfoRoleLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInfoRoleLabel">Info Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td id="info_name"></td>
                    </tr>
                    <tr>
                        <td>Permissions</td>
                        <td>:</td>
                        <td id="info_permissions"></td>
                    </tr>
                    <tr>
                        <td>Menus</td>
                        <td>:</td>
                        <td id="info_menus"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $('#modalInfoRole').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/apis/roles/${id}`,
            }).done((response) => {
                $('#info_name').text(response.data.name)

                var appendPermission = response.data.relationship.permissions.map((item) => {
                    return '<span class="badge badge-success mx-1">' + item.name + '</span>'
                })

                var appendMenu = response.data.relationship.menus.map((item) => {
                    return '<span class="badge badge-success mx-1">' + item.menu_name + '</span>'
                })

                $('#info_permissions').html(appendPermission)
                $('#info_menus').html(appendMenu)
            })
        })
    })
</script>