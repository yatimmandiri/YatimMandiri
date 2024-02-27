<div class="modal fade" id="modalCreateRekening" tabindex="-1" role="dialog" aria-labelledby="modalCreateRekeningLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" id="formRekeningCreate" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateRekeningLabel">Create Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-6">
                        <label for="rekening_name" class="mb-1">Name</label>
                        <input type="text" name="rekening_name" placeholder="Name" class="form-control" id="rekening_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rekening_bank" class="mb-1">Bank</label>
                        <input type="text" name="rekening_bank" placeholder="Bank" class="form-control" id="rekening_bank">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rekening_number" class="mb-1">Number</label>
                        <input type="number" name="rekening_number" placeholder="Number" class="form-control" id="rekening_number">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rekening_provider" class="mb-1">Provider</label>
                        <select name="rekening_provider" id="rekening_provider" class="form-control select2">
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rekening_group" class="mb-1">Group</label>
                        <select name="rekening_group" id="rekening_group" class="form-control select2">
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rekening_token" class="mb-1">Channel</label>
                        <select name="rekening_token" id="rekening_token" class="form-control select2" disabled>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rekening_icon" class="mb-1">Icon</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="rekening_icon" id="rekening_icon">
                            <label class="custom-file-label" for="rekening_icon">Choose file</label>
                        </div>
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
        $('#modalCreateRekening').on('show.bs.modal', function() {
            bsCustomFileInput.init();

            setDataSelect({
                tagid: '#rekening_provider',
                data: [{
                    id: 'Midtrans',
                    text: 'Midtrans',
                }, {
                    id: 'Moota',
                    text: 'Moota',
                }, {
                    id: 'Dana',
                    text: 'Dana',
                }],
                placeholder: 'Select Provider',
                modalid: '#modalCreateRekening'
            })

            setDataSelect({
                tagid: '#rekening_group',
                data: [{
                        id: 'bank_transfer',
                        text: 'Bank Transfer',
                    }, {
                        id: 'e_money',
                        text: 'E-Money',
                    },
                    {
                        id: 'convenience_store',
                        text: 'Convenience Store',
                    },
                    {
                        id: 'cardless_credit',
                        text: 'Cardless Credit',
                    }
                ],
                placeholder: 'Select Group',
                modalid: '#modalCreateRekening'
            })

            $('#rekening_provider').on('change', function(e) {
                let val = $(this).val()
                let channel;

                $('#rekening_token').removeAttr('disabled')

                switch (val) {
                    case 'Moota':
                        ajaxRequest({
                            url: `/moota/rekenings`,
                        }).done((rekenings) => {
                            $('#rekening_token').empty().select2({
                                theme: 'bootstrap-5',
                                placeholder: 'Select Channel',
                                data: rekenings.data.map((item) => {
                                    return {
                                        id: item.bank_id,
                                        text: item.bank_type,
                                    }
                                }),
                            })
                        })
                        break;
                    case 'Dana':
                        channel = [{
                            'id': 'dana',
                            'text': 'Dana Virtual Account'
                        }, ]

                        $('#rekening_token').empty().select2({
                            theme: 'bootstrap-5',
                            placeholder: 'Select Channel',
                            data: channel,
                        })

                        break;

                    default:
                        channel = [{
                                'id': 'bca',
                                'text': 'BCA Virtual Account'
                            },
                            {
                                'id': 'bni',
                                'text': 'BNI Virtual Account'
                            },
                            {
                                'id': 'bri',
                                'text': 'BRI Virtual Account'
                            },
                            {
                                'id': 'mandiri',
                                'text': 'Mandiri Bill Payment'
                            },
                            {
                                'id': 'permata',
                                'text': 'Permata Virtual Account'
                            },
                            {
                                'id': 'gopay',
                                'text': 'Gopay'
                            },
                            {
                                'id': 'shopeepay',
                                'text': 'ShopeePay'
                            },
                        ]

                        $('#rekening_token').empty().select2({
                            theme: 'bootstrap-5',
                            placeholder: 'Select Channel',
                            data: channel,
                        })

                        break;
                }
            })

            $('#formRekeningCreate').ajaxForm({
                url: '/master/rekenings',
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

                    $('#rekening-table').DataTable().ajax.reload()
                    $('#modalCreateRekening').modal('toggle')
                },
                error: function(errors) {
                    Toast.fire({
                        icon: 'error',
                        title: errors.responseJSON.message,
                    })
                }
            })

        })
    })
</script>