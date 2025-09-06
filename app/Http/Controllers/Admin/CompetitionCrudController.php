<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CompetitionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CompetitionCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CompetitionCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Competition::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/league-competition');
        CRUD::setEntityNameStrings('league competition', 'league competitions');
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
        CRUD::column('id');
        CRUD::column('season')->type('select')->model('App\Models\Season')->attribute('name')->entity('currentSeason');
        CRUD::column('host')->type('select')->model('App\Models\University')->attribute('name')->entity('hostUni');

        CRUD::column('when');
        CRUD::column('short');
        CRUD::column('results');
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
        CRUD::setValidation(CompetitionRequest::class);

        // CRUD::field('id');
        CRUD::field('season')->type('select')->model('App\Models\Season')->attribute('name');
        CRUD::field('host')->type('select')->model('App\Models\University')->attribute('name');
        CRUD::field('when');
        CRUD::field('status')->type('select_from_array')->options(['incomplete_setup' => 'incomplete_setup', 'ready' => 'ready', 'finished' => 'finished', 'awaiting_results' => 'awaiting_results'])->default('incomplete_setup');
        CRUD::field('short');
        CRUD::field('results');
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
