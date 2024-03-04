<?php

namespace App\DataTables;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class CampaignDataTable extends DataTable
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
            ->editColumn('campaign_excerpt', function ($row) {
                return Str::limit($row->campaign_excerpt, 50);
            })
            ->editColumn('campaign_nominal', function ($row) {
                return number_format($row->campaign_nominal, 0, ',', '.');
            })
            ->editColumn('campaign_nominal_min', function ($row) {
                return number_format($row->campaign_nominal_min, 0, ',', '.');
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->editColumn('updated_at', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->addColumn('campaign_recomendation', function ($row) {
                $status = 'Not Recomendation';
                $color = 'bg-secondary';

                if ($row->campaign_recomendation == 'Y') {
                    $status = 'Recomendation';
                    $color = 'bg-success';
                }

                return '<span class="badge rounded-pill ' . $color . '" onClick="recomendationConfirmation({
                populer: ' . "'" . $row->campaign_recomendation . "'"  . ',
                tableId: ' . "'#campaign-table'" . ',
                methods: ' . "'PUT'" . ',
                url: ' . "'/apis/campaigns/recomendation/" . $row->id . "'" . ',
            })">' . $status . '</span>';
            })
            ->addColumn('campaign_populer', function ($row) {
                $status = 'Not Populer';
                $color = 'bg-secondary';

                if ($row->campaign_populer == 'Y') {
                    $status = 'Populer';
                    $color = 'bg-success';
                }

                return '<span class="badge rounded-pill ' . $color . '" onClick="populerConfirmation({
                populer: ' . "'" . $row->campaign_populer . "'"  . ',
                tableId: ' . "'#campaign-table'" . ',
                methods: ' . "'PUT'" . ',
                url: ' . "'/apis/campaigns/populer/" . $row->id . "'" . ',
            })">' . $status . '</span>';
            })
            ->addColumn('campaign_status', function ($row) {
                $status = 'Not Active';
                $color = 'bg-secondary';

                if ($row->campaign_status == 'Y') {
                    $status = 'Active';
                    $color = 'bg-success';
                }

                return '<span class="badge rounded-pill ' . $color . '" onClick="activeConfirmation({
                active: ' . "'" . $row->campaign_status . "'"  . ',
                tableId: ' . "'#campaign-table'" . ',
                methods: ' . "'PUT'" . ',
                url: ' . "'/apis/campaigns/status/" . $row->id . "'" . ',
            })">' . $status . '</span>';
            })
            ->addColumn('campaign_featureimage', function ($row) {
                $featureimage = '';

                if ($row->campaign_featureimage != '' || $row->campaign_featureimage != null) {
                    $link = Storage::url($row->campaign_featureimage);
                    $featureimage = '<img src="' . $link . '" class="img-responsive w-50 h-50" alt="campaign_icon" />';
                }

                return $featureimage;
            })
            ->addColumn('action', function ($row) {
                $btnInfo = '';
                $btnEdit = '';
                $btnDelete = '';
                $btnRestore = '';

                if ($row->deleted_at != null) {
                    $btnRestore = '<button onClick="restoreConfirm(' . "'" . route('campaigns.restore', $row->id) . "'" . ', ' . "'#campaign-table'" . ')" class="btn btn-success btn-sm text-white"> <i class="fas fa-trash-arrow-up"></i> </button> ';
                } else {
                    $btnInfo = '<a href="' . route('campaigns.show', $row->id) . '"> <button class="btn btn-info btn-sm text-white"> <i class="fas fa-info-circle"></i> </button> </a> ';
                    $btnEdit = '<a href="' . route('campaigns.edit', $row->id) . '"> <button class="btn btn-warning btn-sm text-white"> <i class="fas fa-edit"></i> </button> </a> ';
                    $btnDelete = '<button onClick="deleteConfirm(' . "'" . route('campaigns.destroy', $row->id) . "'" . ', ' . "'#campaign-table'" . ')" class="btn btn-danger btn-sm text-white"> <i class="fas fa-trash"></i> </button> ';
                }

                return $btnInfo . $btnEdit . $btnRestore;
            })
            ->rawColumns(['campaign_status', 'campaign_populer', 'campaign_recomendation', 'campaign_featureimage', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Campaign $model): QueryBuilder
    {
        $status = $this->request->get('status');
        $populer = $this->request->get('populer');

        return $model
            ->newQuery()
            ->withTrashed()
            ->with(['categories'])
            ->when($status, function ($query) use ($status) {
                if ($status != 'all') {
                    $query->where('campaign_status', $status);
                }
            })
            ->when($populer, function ($query) use ($populer) {
                if ($populer != 'all') {
                    $query->where('campaign_populer', $populer);
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
            ->setTableId('campaign-table')
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
            Column::make('campaign_name')->title('Name'),
            // Column::make('campaign_excerpt'),
            Column::make('campaign_slug')->title('Slug'),
            Column::make('campaign_nominal')->title('Nominal Paket'),
            Column::make('campaign_nominal_min')->title('Nominal Minimal'),
            // Column::make('categories.categories_name')->title('Categories'),
            Column::computed('campaign_populer')->title('Populer'),
            Column::computed('campaign_status')->title('Status'),
            Column::computed('campaign_recomendation')->title('Recomendation'),
            // Column::computed('campaign_featureimage'),
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
        return 'Campaign_' . date('YmdHis');
    }
}
