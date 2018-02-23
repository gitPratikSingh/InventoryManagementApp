<?php

namespace App\DataTables;

use App\Equipment;
use DB;
use Yajra\Datatables\Services\DataTable;

class EquipmentDataTable extends DataTable
{
    // protected $printPreview  = 'path.to.print.preview.view';

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
      $datatables = Equipment::distinct()->select([
          'equipment.id',
          'equipment.active',
          'equipment.surplused',
          'equipment.equipment_name',
          'db_type.name as type_name',
          'equipment.serial_number',
          'equipment.cams',
          'db_make.name as make_name',
          'equipment.model',
          'db_building.name as building_name',
          'equipment.room',
          'equipment.config',
          'equipment.owner',
          'equipment.primary_user',
          'equipment.warranty',
          'db_groups.name as group_name',
          'equipment.retired_at',
          'equipment.surplused_at',
          'equipment.created_at',
          'equipment.updated_at',

          'db_os.name as os_name',
          'db_computer.memory as memory',
          'db_computer.processor as processor',
          'db_computer.harddrive as harddrive',
          'db_computer.ip as ip',
          'db_domain.name as domain',
          'db_computer.ethernet as ethernet',
          'db_computer.hostname as hostname',

          'db_purchase.acct_no as acct_no',
          'db_purchase.po_no as po_no',
          'db_purchase.quote_no as quote_no',
          'db_purchase.reseller as reseller',
          'db_purchase.price as price',
          'db_purchase.date_purchased as date_purchased',
          DB::raw('(SELECT GROUP_CONCAT(CONCAT(\'{"note":"\', note, \'", "date":"\',created_at,\'"}\')) list FROM notes as db_notes WHERE db_notes.equipment_id=equipment.id ) as notes')
          ])
          ->leftJoin(config('constants.DB_EQUIPMENT_TYPE').' as db_type',            'db_type.id',                '=', 'equipment.type_id')
          ->leftJoin(config('constants.DB_EQUIPMENT_MAKE').' as db_make',            'db_make.id',                '=', 'equipment.make_id')
          ->leftJoin(config('constants.DB_GROUPS').' as db_groups',                  'db_groups.id',              '=', 'equipment.group_id')
          ->leftJoin(config('constants.DB_BUILDINGS').' as db_building',             'db_building.id',            '=', 'equipment.building_id')
          ->leftJoin(config('constants.DB_EQUIPMENT_COMPUTER').' as db_computer',    'db_computer.equipment_id',  '=', 'equipment.id')

          ->leftJoin(config('constants.DB_EQUIPMENT_PURCHASE').' as db_purchase',    'db_purchase.equipment_id',  '=', 'equipment.id')
          ->leftJoin(config('constants.DB_DOMAIN').' as db_domain',                  'db_domain.id',              '=', 'db_computer.domain_id')
          ->leftJoin(config('constants.DB_OS').' as db_os',                          'db_os.id',                  '=', 'db_computer.os_id')

          ->where('equipment.unit_id', 87);

        return $this->applyScopes($datatables);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
      return $this->builder()
      ->columns([
          'id',
          'name',
          'email',
          'created_at',
          'updated_at',
      ])
      ->parameters([
          'dom' => 'Bfrtip',
          'buttons' => ['csv', 'excel', 'pdf', 'print', 'reset', 'reload'],
      ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'id',
            // add your columns
            'created_at',
            'updated_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'users';
    }
}
