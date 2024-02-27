<div class="modal fade" id="modalUpdateRekening" tabindex="-1" role="dialog" aria-labelledby="modalUpdateRekeningLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" id="formRekeningUpdate" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdateRekeningLabel">Update Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-6">
                        <label for="rekening_name" class="mb-1">Name</label>
                        <input type="text" name="rekening_name" placeholder="Name" class="form-control" id="e_rekening_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rekening_bank" class="mb-1">Bank</label>
                        <input type="text" name="rekening_bank" placeholder="Bank" class="form-control" id="e_rekening_bank">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rekening_number" class="mb-1">Number</label>
                        <input type="number" name="rekening_number" placeholder="Number" class="form-control" id="e_rekening_number">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rekening_provider" class="mb-1">Provider</label>
                        <select name="rekening_provider" id="e_rekening_provider" class="form-control select2">
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rekening_group" class="mb-1">Group</label>
                        <select name="rekening_group" id="e_rekening_group" class="form-control select2">
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rekening_token" class="mb-1">Channel</label>
                        <select name="rekening_token" id="e_rekening_token" class="form-control select2">
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rekening_icon" class="mb-1">Icon</label>
                        <input type="file" name="rekening_icon" placeholder="Icon" class="form-control" id="e_rekening_icon">
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
        $('#modalUpdateRekening').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            // getRekenings({
            //     id: id
            // })

            // setDataSelect({
            //     tagid: '#e_rekening_provider',
            //     data: [{
            //         id: 'Midtrans',
            //         text: 'Midtrans',
            //     }, {
            //         id: 'Moota',
            //         text: 'Moota',
            //     }],
            //     dataSelected: rekenings.rekening_provider,
            //     placeholder: 'Select Provider',
            //     modalid: '#modalUpdateRekening'
            // })

            // setDataSelect({
            //     tagid: '#e_rekening_group',
            //     data: [{
            //             id: 'bank_transfer',
            //             text: 'Bank Transfer',
            //         }, {
            //             id: 'e_money',
            //             text: 'E-Money',
            //         },
            //         {
            //             id: 'convenience_store',
            //             text: 'Convenience Store',
            //         },
            //         {
            //             id: 'cardless_credit',
            //             text: 'Cardless Credit',
            //         }
            //     ],
            //     dataSelected: rekenings.rekening_group,
            //     placeholder: 'Select Group',
            //     modalid: '#modalUpdateRekening'
            // })

            // const channel = [{
            //         'id': 'bca',
            //         'text': 'BCA Virtual Account'
            //     },
            //     {
            //         'id': 'bni',
            //         'text': 'BNI Virtual Account'
            //     },
            //     {
            //         'id': 'bri',
            //         'text': 'BRI Virtual Account'
            //     },
            //     {
            //         'id': 'echannel',
            //         'text': 'Mandiri Bill Payment'
            //     },
            //     {
            //         'id': 'permata',
            //         'text': 'Permata Virtual Account'
            //     },
            //     {
            //         'id': 'gopay',
            //         'text': 'Gopay'
            //     },
            //     {
            //         'id': 'shopeepay',
            //         'text': 'ShopeePay'
            //     },
            // ]

            // switch (rekenings.rekening_provider) {
            //     case 'Moota':
            //         getMootaRekening()

            //         $('#e_rekening_token').empty().select2({
            //             theme: 'bootstrap-5',
            //             placeholder: 'Select Channel',
            //             data: dataMootaRekening,
            //         }).val(rekenings.rekening_token).trigger('change')

            //         break;
            //     default:
            //         $('#e_rekening_token').empty().select2({
            //             theme: 'bootstrap-5',
            //             placeholder: 'Select Channel',
            //             data: channel,
            //         }).val(rekenings.rekening_token).trigger('change')

            //         break;
            // }

            // $('#e_rekening_provider').on('change', function(e) {
            //     let val = $(this).val()

            //     switch (val) {
            //         case 'Moota':
            //             getMootaRekenings()

            //             $('#e_rekening_token').empty().select2({
            //                 theme: 'bootstrap-5',
            //                 placeholder: 'Select Channel',
            //                 data: mootaRekeningList,
            //             }).val(rekenings.rekening_token).trigger('change')

            //             break;
            //         default:

            //             $('#e_rekening_token').empty().select2({
            //                 theme: 'bootstrap-5',
            //                 placeholder: 'Select Channel',
            //                 data: channel,
            //             }).val(rekenings.rekening_token).trigger('change')

            //             break;
            //     }
            // })

            // setInputValue('#e_rekening_name', rekenings.rekening_name)
            // setInputValue('#e_rekening_bank', rekenings.rekening_bank)
            // setInputValue('#e_rekening_number', rekenings.rekening_number)

            ajaxRequest({
                url: `/apis/rekenings/${id}`,
            }).done((rekenings) => {
                $('#e_rekening_name').val(rekenings.data.rekening_name)
                $('#e_rekening_bank').val(rekenings.data.rekening_bank)
                $('#e_rekening_number').val(rekenings.data.rekening_number)

                setDataSelect({
                    tagid: '#e_rekening_provider',
                    data: [{
                        id: 'Midtrans',
                        text: 'Midtrans',
                    }, {
                        id: 'Moota',
                        text: 'Moota',
                    }],
                    dataSelected: rekenings.data.rekening_provider,
                    placeholder: 'Select Provider',
                    modalid: '#modalUpdateRekening'
                })

                setDataSelect({
                    tagid: '#e_rekening_group',
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
                    dataSelected: rekenings.data.rekening_group,
                    placeholder: 'Select Group',
                    modalid: '#modalUpdateRekening'
                })

                const channel = [{
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
                        'id': 'echannel',
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

                switch (rekenings.rekening_provider) {
                    case 'Moota':
                        ajaxRequest({
                            url: `/moota/rekenings`,
                        }).done((rekenings) => {
                            $('#e_rekening_token').empty().select2({
                                theme: 'bootstrap-5',
                                placeholder: 'Select Channel',
                                data: rekenings.data.map((item) => {
                                    return {
                                        id: item.bank_id,
                                        text: item.bank_type,
                                    }
                                }),
                            }).val(rekenings.data.rekening_token).trigger('change')
                        })
                        break;
                    default:
                        $('#e_rekening_token').empty().select2({
                            theme: 'bootstrap-5',
                            placeholder: 'Select Channel',
                            data: channel,
                        }).val(rekenings.data.rekening_token).trigger('change')

                        break;
                }

                $('#e_rekening_provider').on('change', function(e) {
                    let val = $(this).val()

                    switch (val) {
                        case 'Moota':
                            ajaxRequest({
                                url: `/moota/rekenings`,
                            }).done((rekenings) => {
                                $('#e_rekening_token').empty().select2({
                                    theme: 'bootstrap-5',
                                    placeholder: 'Select Channel',
                                    data: rekenings.data.map((item) => {
                                        return {
                                            id: item.bank_id,
                                            text: item.bank_type,
                                        }
                                    }),
                                }).val(rekenings.data.rekening_token).trigger('change')
                            })

                            break;
                        default:

                            $('#e_rekening_token').empty().select2({
                                theme: 'bootstrap-5',
                                placeholder: 'Select Channel',
                                data: channel,
                            }).val(rekenings.rekening_token).trigger('change')

                            break;
                    }
                })
            })

            $('#formRekeningUpdate').ajaxForm({
                url: `/master/rekenings/${id}`,
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
                    $('#modalUpdateRekening').modal('toggle')
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