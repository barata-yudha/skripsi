<?php

namespace App\DataTables;

use App\Helpers\MyHelper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
            ->editColumn('created_at', function($user) {
                $dated = Carbon::parse($user->created_at)->format('Y-m-d');
                return "
                    <p style='margin: 0.5rem 0 0 0; font-style: italic;'  class='form-text text-muted'>{$dated}</p>
                ";
            })
            ->editColumn('foto', function($user) {
                return MyHelper::avatarUser($user);
            })
            ->editColumn('role', function($user) {
                $str = "<span class='badge bg-info'>". $user->role ."</span>";
                return $str;
            })
            ->addIndexColumn()
            ->addColumn('action', function($user) {
                if (Auth::user()->id == $user->id) {
                    return '<badge class="badge bg-info">Anda</badge>';
                } else {
                    if (Auth::user()->role == 'owner') {
                        return "
                        <div class='d-flex justify-content-center'>
                            <a href='" . route('dashboard.user.edit', $user->id) . "' class='btn btn-sm btn-warning me-1'>
                            <i class='mdi mdi-pencil align-middle font-size-12'></i> Edit
                            </a>
                            <form action='" . route('dashboard.user.destroy', $user->id) . "' method='post' style='display: inline-block;'>
                                " . csrf_field() . "
                                " . method_field('DELETE') . "
                                <button type='button' class='btn btn-sm btn-danger buttonDeletion'>
                                    <i class='mdi mdi-trash-can align-middle font-size-12'></i> Hapus
                                </button>
                            </form>
                        </div>
                        ";
                    }
                }
            })
            ->rawColumns(['action', 'foto', 'role', 'created_at']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
                    ->setTableId('userdatatable-table')
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
            Column::make('created_at')->title('Tanggal dibuat')->width("10px")->hidden(),
            Column::make('foto')->title('Foto'),
            Column::make('name')->title('Nama'),
            Column::make('email')->title('Email'),
            Column::make('username')->title('Username'),
            Column::make('role')->title('Peran'),
            Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(140)
                    ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
