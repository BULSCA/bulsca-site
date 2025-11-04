<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CompetitionUniPlaceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CompetitionUniPlaceCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CompetitionUniPlaceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\CompetitionUniPlace::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/competition-uni-place');
        CRUD::setEntityNameStrings('competition uni place', 'competition uni places');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::column('id');
        CRUD::column('season_uni')->type('select')->model('App\Models\SeasonUni')->attribute('uni')->entity('getUni');
        CRUD::column('league_comp')->type('select')->model('App\Models\Competition')->attribute('id')->entity('getComp');
        CRUD::column('overal_pos');

        CRUD::column('a_pos');
        CRUD::column('b_pos');

        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     *
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CompetitionUniPlaceRequest::class);

        CRUD::field('season_uni')->type('select')->model('App\Models\SeasonUni')->attribute('currentUni');
        CRUD::field('league_comp')->type('select')->model('App\Models\Competition')->attribute('hostUni');

        CRUD::field('a_pos');
        CRUD::field('b_pos');

        CRUD::field('overal_pos');

        CRUD::field('created_at')->default(date('Y-m-d H:i:s'));
        CRUD::field('updated_at')->default(date('Y-m-d H:i:s'));

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     *
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
