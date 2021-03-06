<?php

namespace App\Http\Controllers\Admin\Settings;

use Carbon\Carbon;
use App\Models\System\League;
use Illuminate\Http\Request;
use App\Http\Controllers\EditorController;

class SeasonController extends EditorController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->middleware('auth');
        $this->setPrimaryClass('App\Models\System\Season');
    }

    /**
     * Show the view for this controller
     * 
     * @return \Illuminate\Http\Response
     */
    public function view() {
        $page = 'Seasons';
        return view('admin.settings.seasons', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function create(Request $request) {
        $class = $this->getPrimaryClass();
        $object = new $class();
        $data = $this->data[$object->getTable()];
        $start_date = Carbon::createFromFormat('d/m/Y', $data['start_date'])->startOfDay();
        $end_date = Carbon::createFromFormat('d/m/Y', $data['end_date'])->startOfDay();
        $object->fill($data);
        $object->start_date = $start_date;
        $object->end_date = $end_date;
        if (!$object->save()) {
            $this->setError('Failed to create the entry');
        }
        return $this->getRows($request, $object->id);
    }

    /**
     * Edit a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function edit(Request $request) {
        $class = $this->getPrimaryClass();
        $object = $class::findOrFail($this->primary_key);
        $data = $this->data[$object->getTable()];
        $start_date = Carbon::createFromFormat('d/m/Y', $data['start_date'])->startOfDay();
        $end_date = Carbon::createFromFormat('d/m/Y', $data['end_date'])->startOfDay();
        $object->fill($data);
        $object->start_date = $start_date;
        $object->end_date = $end_date;
        if (!$object->save()) {
            $this->setError('Failed to create the entry');
        }
        return $this->getRows($request, $object->id);
    }

    /**
     * Return a list of resource.
     * 
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    protected function getRows(Request $request, $id = 0) {
        $object = $this->getPrimaryClass();
        $query = $object::select(['seasons.*']);
        if ($id > 0) {
            return $query->where('seasons.id', $id)->first();
        }
        return $query->get();
    }

    /**
     * @return \App\Http\Controllers\type|array
     */
    protected function getOptions() {
        //$league_options = editorOptions(League::orderBy('description')->get(), ["value" => 0, "label" => "Select a League"]);
        return [
                //"seasons.league_id" => $league_options,
        ];
    }

    protected function format($data): array {
        return [
            "seasons" => [
                "id" => $data->id,
                "description" => $data->description,
                "start_date" => $data->start_date->format('d/m/Y'),
                "end_date" => $data->end_date->format('d/m/Y'),
                "active" => $data->active
            ]
        ];
    }

    protected function setRules(array $rules = array()): array {
        $this->rules = [
            'seasons.start_date' => 'required|date_format:d/m/Y',
            'seasons.end_date' => 'required|date_format:d/m/Y',
            'seasons.description' => 'required|string|min:3',
            'seasons.active' => 'required|boolean',
        ];
        if (count($rules) > 0) {
            $this->rules = array_merge($this->rules, $rules);
        }
        return $this->rules;
    }

}
