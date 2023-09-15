<?php

namespace App\DataTables;

use App\Helpers\MyHelper;
use App\Models\Customer;
use App\Models\Odp;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OdpDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('port', function($odp) {
                return $odp->port_used .'/'. $odp->port_max;
            })
            ->editColumn('jarak_pop', function($odp) {
                return $odp->jarak_pop_sync . ' m';
            })
            ->editColumn('koordinat', function($odp) {
                $coord = $odp->latitude.','.$odp->longitude;
                $link = 'https://maps.google.com?q=' . $coord;
                return '<a href="'. $link .'" target="_blank">'. $coord .'</a>';
            })
            ->filterColumn('koordinat', function($query, $keyword) {
                $query->whereRaw("CONCAT(latitude, ',', longitude) like ?", ["%{$keyword}%"]);
            })
            ->editColumn('icon', function($odp) {
                if ($odp->icon) {
                    return '<img src="'. MyHelper::get_avatar($odp->icon) .'" style="width: 50px;">';
                }

                return '';
            })
            ->editColumn('doc', function($odp) {
                if ($odp->doc) {
                    return '<a href="'. MyHelper::get_avatar($odp->doc) .'">Lihat Lampiran</a>';
                }

                return '';
            })
            ->editColumn('alamat', function($odp) {
                return Str::limit($odp->alamat, 20, '...');
            })
            ->editColumn('created_at', function($odp) {
                return Carbon::parse($odp->expired_at)->format('d M Y');
            })
            ->addColumn('action', function($odp) {
                $str = "
                    <div class='d-flex justify-content-center'>
                        <a href='" . route('dashboard.odp.edit', $odp->id) . "' class='btn btn-sm btn-warning me-1'>
                        <i class='mdi mdi-pencil align-middle font-size-12'></i> Edit
                        </a>
                        ";
                if ($odp->port_used == 0) {
                    $str .= "<form action='" . route('dashboard.odp.destroy', $odp->id) . "' method='post' style='display: inline-block;'>
                    " . csrf_field() . "
                    " . method_field('DELETE') . "
                    <button type='button' class='btn btn-sm btn-danger buttonDeletion'>
                        <i class='mdi mdi-trash-can align-middle font-size-12'></i> Hapus
                    </button>
                </form>";
                }
                $str .="
                    </div>
                ";

                return $str;
            })
            ->rawColumns(['action', 'icon', 'doc', 'koordinat']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\OdpDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Odp $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('Odpdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1, 'desc');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex', '#')->width("10px"),
            Column::make('created_at')->title('Tgl Dibuat')->hidden(),
            Column::make('icon')->title('Icon'),
            Column::make('kode')->title('Kode'),
            Column::make('koordinat')->title('Koordinat')->sortable(false),
            Column::make('address')->title('Alamat'),
            Column::make('power')->title('Redaman'),
            Column::computed('port')->title('Port'),
            Column::make('jarak_pop')->title('Jarak POP'),
            Column::make('doc')->title('Dokumentasi'),
            Column::make('keterangan')->title('Keterangan'),
            Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(140)
                    ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Odp_' . date('YmdHis');
    }
}
