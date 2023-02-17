<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function ($user) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)
                    ->format('d-m-Y h:i:s a');
                return $formatedDate;
            })
            ->editColumn('updated_at', function ($user) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->updated_at)
                    ->format('d-m-Y h:i:s a');
                return $formatedDate;
            })
            ->addColumn('edit', function ($user) {
                $url = url(route('admin.users.edit', $user->id));
                $EditButton = '<a href="' . $url . '">Edit</a>';
                return $EditButton;
            })
            ->addColumn('delete', function ($user) {
                $url = url(route('admin.users.destroy', $user->id));
                $csrf = csrf_token();
                $DelButton = '<form action="' . $url . '" method="post">
                    <input type="hidden" name="_token" value="' . $csrf . '" />
                    <input type="hidden" name="_method" value="delete">
                    <button class="btn btn-danger btn-sm">del</button>
                    </form>';
                return $DelButton;
            })
            ->rawColumns(['edit', 'delete'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('edit')
                ->exportable(false)
                ->printable(false)
                ->width(60),
            Column::computed('delete')
                ->exportable(false)
                ->printable(false)
                ->width(60),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
