<?php

namespace App\DataTables;

use App\Helpers\MyHelper;
use App\Models\Timeslot;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TimeslotRejectDataTable extends DataTable
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
            ->editColumn('customer_name', function($timeslot) {
                return $timeslot->customer->nama;
            })
            ->editColumn('customer_id', function($timeslot) {
                return $timeslot->customer_id;
            })
            ->editColumn('customer_address', function($timeslot) {
                return $timeslot->customer->alamat;
            })
            ->editColumn('odp', function($timeslot) {
                return $timeslot->odp->kode;
            })
            ->editColumn('ont', function($timeslot) {
                return $timeslot->ont->merk_ont . ' ' . $timeslot->ont->type_ont . ' ' . $timeslot->ont->versi_ont;
            })
            ->editColumn('koordinat', function($timeslot) {
                $coord = $timeslot->latitude.','.$timeslot->longitude;
                $link = 'https://maps.google.com?q=' . $coord;
                return '<a href="'. $link .'" target="_blank">'. $coord .'</a>';
            })
            ->editColumn('icon', function($timeslot) {
                if ($timeslot->icon) {
                    return '<img src="'. MyHelper::get_avatar($timeslot->icon) .'" style="width: 50px;">';
                }

                return '';
            })
            ->editColumn('doc', function($timeslot) {
                if ($timeslot->doc) {
                    return '<a href="'. MyHelper::get_avatar($timeslot->doc) .'">Lihat Lampiran</a>';
                }

                return '';
            })
            ->editColumn('created_at', function($timeslot) {
                return Carbon::parse($timeslot->expired_at)->format('d M Y');
            })
            ->editColumn('status', function($timeslot) {
                $str = MyHelper::statusTicket($timeslot);
                return $str;
            })
            ->addColumn('action', function($timeslot) {
                return "
                    <div class='d-flex justify-content-center'>
                        <form action='" . route('dashboard.timeslot.destroy', $timeslot->id) . "' method='post' style='display: inline-block;'>
                                " . csrf_field() . "
                                " . method_field('DELETE') . "
                                <button type='button' class='btn btn-sm btn-danger buttonDeletion'>
                                    <i class='mdi mdi-trash-can align-middle font-size-12'></i> Hapus
                                </button>
                            </form>
                    </div>
                ";
            })
            ->rawColumns(['action', 'doc', 'status', 'koordinat']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\TimeslotDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Timeslot $model)
    {
        return $model->with(['customer'])->where('status', 'reject')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('TimeslotRejecteddatatable-table')
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
            Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(140)
                    ->addClass('text-center'),
            Column::make('customer_name')->name('customer.nama')->title('Customer Name'),
            Column::make('customer_id')->title('Customer ID'),
            Column::make('customer_address')->name('customer.alamat')->title('Address'),
            Column::make('koordinat')->title('Koordinat'),
            Column::computed('odp')->title('ODP'),
            Column::computed('ont')->title('ONT'),
            Column::computed('serial_number')->title('Serial Number'),
            Column::computed('status')->title('Status'),
            Column::make('cable_distance')->title('Cable Distance'),
            Column::make('doc')->title('Dokumentasi'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TimeslotReject_' . date('YmdHis');
    }
}
