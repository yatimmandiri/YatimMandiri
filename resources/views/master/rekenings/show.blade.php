<div class="modal fade" id="modalInfoRekening" tabindex="-1" role="dialog" aria-labelledby="modalInfoRekeningLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInfoRekeningLabel">Info Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <tr>
                        <td>Name</td>
                        <td id="info_rekening_name"></td>
                    </tr>
                    <tr>
                        <td>Bank</td>
                        <td id="info_rekening_bank"></td>
                    </tr>
                    <tr>
                        <td>Number</td>
                        <td id="info_rekening_number"></td>
                    </tr>
                    <tr>
                        <td>Provider</td>
                        <td id="info_rekening_provider"></td>
                    </tr>
                    <tr>
                        <td>Group</td>
                        <td id="info_rekening_group"></td>
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
        $('#modalInfoRekening').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/apis/rekenings/${id}`,
            }).done((rekenings) => {
                $('#info_rekening_name').text(rekenings.data.rekening_name)
                $('#info_rekening_bank').text(rekenings.data.rekening_bank)
                $('#info_rekening_number').text(rekenings.data.rekening_number)
                $('#info_rekening_provider').text(rekenings.data.rekening_provider)
                $('#info_rekening_group').text(rekenings.data.rekening_group)
            })
        })
    })
</script>