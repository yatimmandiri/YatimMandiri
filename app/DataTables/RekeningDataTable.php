<?php

namespace App\DataTables;

use App\Models\Rekening;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RekeningDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->editColumn('updated_at', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->addColumn('rekening_icon', function ($row) {
                $icon = '';

                if ($row->rekening_icon != '' || $row->rekening_icon != null) {
                    $link = Storage::url($row->rekening_icon);
                    $icon = '<img src="' . $link . '" class="img-responsive w-50 h-50" alt="rekening_icon" />';
                }

                return $icon;
            })
            ->addColumn('rekening_populer', function ($row) {
                $status = 'Not Populer';
                $color = 'bg-secondary';

                if ($row->rekening_populer == 'Y') {
                    $status = 'Active';
                    $color = 'bg-success';
                }

                return '<span class="badge rounded-pill ' . $color . '" onClick="populerConfirmation({
                active: ' . "'" . $row->rekening_populer . "'"  . ',
                tableId: ' . "'#rekening-table'" . ',
                methods: ' . "'PUT'" . ',
                url: ' . "'/apis/rekenings/populer/" . $row->id . "'" . ',
            })">' . $status . '</span>';
            })
            ->addColumn('rekening_status', function ($row) {
                $status = 'Not Active';
                $color = 'bg-secondary';

                if ($row->rekening_status == 'Y') {
                    $status = 'Active';
                    $color = 'bg-success';
                }

                return '<span class="badge rounded-pill ' . $color . '" onClick="activeConfirmation({
                active: ' . "'" . $row->rekening_status . "'"  . ',
                tableId: ' . "'#rekening-table'" . ',
                methods: ' . "'PUT'" . ',
                url: ' . "'/apis/rekenings/status/" . $row->id . "'" . ',
            })">' . $status . '</span>';
            })
            ->addColumn('action', function ($row) {
                $btnInfo = '<button class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#modalInfoRekening" data-id="' . $row->id . '"> <i class="fas fa-info-circle"></i> </button> ';
                $btnEdit = '<button class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#modalUpdateRekening" data-id="' . $row->id . '"> <i class="fas fa-edit"></i> </button> ';
                $btnDelete = '<button onClick="deleteConfirm(' . "'" . route('rekenings.destroy', $row->id) . "'" . ', ' . "'#rekening-table'" . ')" class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"></i> </button> ';
                $btnRestore = '';

                return $btnInfo . $btnEdit  . $btnRestore;
            })
            ->rawColumns(['rekening_populer', 'rekening_status', 'rekening_icon', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Rekening $model): QueryBuilder
    {
        return $model
            ->newQuery()
            ->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('rekening-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->selectStyleSingle()
            ->responsive(true)
            ->autoWidth(true)
            ->lengthMenu([50, 100, 250, 500])
            ->orderBy(1);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('rekening_name'),
            Column::make('rekening_bank'),
            Column::make('rekening_number'),
            Column::make('rekening_token'),
            Column::make('rekening_group'),
            Column::computed('rekening_icon'),
            Column::computed('rekening_populer'),
            Column::computed('rekening_status'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Rekening_' . date('YmdHis');
    }
}
