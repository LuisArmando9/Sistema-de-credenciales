<?php

namespace App\View\Components\Admin\Modal;

use App\helpers\Csv\Constants\Constants;
use App\Models\CCPdf;
use Illuminate\View\Component;

class CredentialInfo extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
   

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.modal.credential-info')
        ->with("credentialNumber", CCPdf::getTotal());
    }
}
