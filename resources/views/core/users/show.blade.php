<div class="modal fade" id="modalInfoUser" tabindex="-1" role="dialog" aria-labelledby="modalInfoUserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInfoUserLabel">Info Data</h5>
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
                        <td>Email</td>
                        <td>:</td>
                        <td id="info_email"></td>
                    </tr>
                    <tr>
                        <td>Roles</td>
                        <td>:</td>
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
        $('#modalInfoUser').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/apis/users/${id}`,
            }).done((response) => {
                $('#info_name').text(response.data.name)
                $('#info_email').text(response.data.email)

                var appendRole = response.data.relationship.roles.map((item) => {
                    return '<span class="badge badge-success mx-1">' + item.name + '</span>'
                })

                $('#info_roles').html(appendRole)
            })

        })
    })
</script>