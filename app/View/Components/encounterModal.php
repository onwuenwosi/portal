<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\ClientModel;
use Illuminate\Support\Facades\DB;


class EncounterModal extends Component
{
    /**
     * The credentials retrieved from the ClientModel.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $credentials;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // You can fetch the data here or in the render method
        $this->credentials = DB::table('client_models')
            ->where('enrolleetype', "=", 'Principal')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.encounter-modal', [
            'credentials' => $this->credentials,
        ]);
    }
}