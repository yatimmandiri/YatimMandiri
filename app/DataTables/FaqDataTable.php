<?php

namespace App\DataTables;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FaqDataTable extends DataTable
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
            ->addColumn('faq_status', function ($row) {

                $status = 'Not Active';
                $color = 'bg-secondary';

                if ($row->faq_status == 'Y') {
                    $status = 'Active';
                    $color = 'bg-success';
                }

                return '<span class="badge rounded-pill ' . $color . '" onClick="activeConfirmation({
            active: ' . "'" . $row->faq_status . "'"  . ',
            tableId: ' . "'#faq-table'" . ',
            methods: ' . "'PUT'" . ',
            url: ' . "'/apis/faqs/status/" . $row->id . "'" . ',
        })">' . $status . '</span>';
            })
            ->addColumn('action', function ($row) {
                $btnInfo = '';
                $btnEdit = '';
                $btnDelete = '';
                $btnRestore = '';

                if ($row->deleted_at != null) {
                    $btnRestore = '<button onClick="restoreConfirm(' . "'" . route('faqs.restore', $row->id) . "'" . ', ' . "'#faq-table'" . ')" class="btn btn-success btn-sm text-white"> <i class="fas fa-trash-arrow-up"></i> </button> ';
                } else {
                    $btnInfo = '<button class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#modalInfoFaq" data-id="' . $row->id . '"> <i class="fas fa-info-circle"></i> </button> ';
                    $btnEdit = '<button class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#modalUpdateFaq" data-id="' . $row->id . '"> <i class="fas fa-edit"></i> </button> ';
                    $btnDelete = '<button onClick="deleteConfirm(' . "'" . route('faqs.destroy', $row->id) . "'" . ', ' . "'#faq-table'" . ')" class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"></i> </button> ';
                }

                return $btnInfo . $btnEdit . $btnRestore;
            })
            ->rawColumns(['faq_status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Faq $model): QueryBuilder
    {
        $categories = $this->request->get('categories');

        return $model
            ->newQuery()
            ->withTrashed()
            ->with(['categories'])
            ->when($categories, function ($query) use ($categories) {
                if ($categories != null) {
                    $query->where('categories_id', $categories);
                }
            })
            ->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('faq-table')
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
            Column::make('faq_name'),
            Column::make('faq_content'),
            Column::make('categories.categories_name')->title('Categories'),
            Column::computed('faq_status'),
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
        return 'Faq_' . date('YmdHis');
    }
}
