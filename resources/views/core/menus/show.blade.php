<div class="modal fade" id="modalInfoMenu" tabindex="-1" role="dialog" aria-labelledby="modalInfoMenuLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInfoMenuLabel">Info Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <tr>
                        <td>Name</td>
                        <td id="info_menu_name"></td>
                    </tr>
                    <tr>
                        <td>Link</td>
                        <td id="info_menu_link"></td>
                    </tr>
                    <tr>
                        <td>Icon</td>
                        <td id="info_menu_icon"></td>
                    </tr>
                    <tr>
                        <td>Parent</td>
                        <td id="info_menu_parent"></td>
                    </tr>
                    <tr>
                        <td>Roles</td>
                        <td id="info_roles"></td>
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
        $('#modalInfoMenu').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/apis/menus/${id}`,
            }).done((response) => {
                $('#info_menu_name').text(response.data.menu_name)
                $('#info_menu_link').text(response.data.menu_link)
                $('#info_menu_icon').text(response.data.menu_icon)

                ajaxRequest({
                    url: `/apis/menus/${response.data.menu_parent}`,
                }).done((response) => {
                    $('#info_menu_parent').text(response.data.menu_name)
                }).fail((response) => {
                    $('#info_menu_parent').text(null)
                })

                var appendRole = response.data.relationship.roles.map((item) => {
                    return '<span class="badge badge-success mx-1">' + item.name + '</span>'
                })

                $('#info_roles').html(appendRole)
            })

        })
    })
</script>