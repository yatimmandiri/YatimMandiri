<?php

namespace App\DataTables;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
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
            ->addColumn('categories_populer', function ($row) {
                $status = 'Not Populer';
                $color = 'bg-secondary';

                if ($row->categories_populer == 'Y') {
                    $status = 'Populer';
                    $color = 'bg-success';
                }

                return '<span class="badge rounded-pill ' . $color . '" onClick="populerConfirmation({
            populer: ' . "'" . $row->categories_populer . "'"  . ',
            tableId: ' . "'#category-table'" . ',
            methods: ' . "'PUT'" . ',
            url: ' . "'/apis/categories/populer/" . $row->id . "'" . ',
        })">' . $status . '</span>';
            })
            ->addColumn('categories_status', function ($row) {
                $status = 'Not Active';
                $color = 'bg-secondary';

                if ($row->categories_status == 'Y') {
                    $status = 'Active';
                    $color = 'bg-success';
                }

                return '<span class="badge rounded-pill ' . $color . '" onClick="activeConfirmation({
            active: ' . "'" . $row->categories_status . "'"  . ',
            tableId: ' . "'#category-table'" . ',
            methods: ' . "'PUT'" . ',
            url: ' . "'/apis/categories/status/" . $row->id . "'" . ',
        })">' . $status . '</span>';
            })
            ->addColumn('categories_icon', function ($row) {
                $icon = '';

                if ($row->categories_icon != '' || $row->categories_icon != null) {
                    $link = Storage::url($row->categories_icon);
                    $icon = '<img src="' . $link . '" class="img-responsive w-50 h-50" alt="categories_icon" />';
                }

                return $icon;
            })
            ->addColumn('categories_featureimage', function ($row) {
                $featureimage = '';

                if ($row->categories_featureimage != '' || $row->categories_featureimage != null) {
                    $link = Storage::url($row->categories_featureimage);
                    $featureimage = '<img src="' . $link . '" class="img-responsive w-50 h-50" alt="categories_featureimage" />';
                }

                return $featureimage;
            })
            ->addColumn('action', function ($row) {
                $btnInfo = '';
                $btnEdit = '';
                $btnDelete = '';
                $btnRestore = '';

                if ($row->deleted_at != null) {
                    $btnRestore = '<button onClick="restoreConfirm(' . "'" . route('categories.restore', $row->id) . "'" . ', ' . "'#category-table'" . ')" class="btn btn-success btn-sm text-white"> <i class="fas fa-trash-arrow-up"></i> </button> ';
                } else {
                    $btnInfo = '<a href="' . route('categories.show', $row->id) . '"> <button class="btn btn-info btn-sm text-white"> <i class="fas fa-info-circle"></i> </button> </a> ';
                    $btnEdit = '<a href="' . route('categories.edit', $row->id) . '"> <button class="btn btn-warning btn-sm text-white"> <i class="fas fa-edit"></i> </button> </a> ';
                    $btnDelete = '<button onClick="deleteConfirm(' . "'" . route('categories.destroy', $row->id) . "'" . ', ' . "'#category-table'" . ')" class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"></i> </button> ';
                }

                return $btnInfo . $btnEdit . $btnRestore;
            })
            ->rawColumns(['action', 'categories_status', 'categories_populer', 'categories_icon', 'categories_featureimage'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Category $model): QueryBuilder
    {
        $status = $this->request->get('status');
        $populer = $this->request->get('populer');

        return $model
            ->newQuery()
            ->withTrashed()
            ->when($status, function ($query) use ($status) {
                if ($status != 'all') {
                    $query->where('categories_status', $status);
                }
            })
            ->when($populer, function ($query) use ($populer) {
                if ($populer != 'all') {
                    $query->where('categories_populer', $populer);
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
            ->setTableId('category-table')
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
            Column::make('categories_name'),
            Column::make('categories_slug'),
            Column::computed('categories_icon'),
            Column::computed('categories_featureimage'),
            Column::computed('categories_populer'),
            Column::computed('categories_status'),
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
        return 'Category_' . date('YmdHis');
    }
}
