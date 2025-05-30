<?php

namespace App\Http\ViewComposers;
use App\Repositories\UserRepository;
use Illuminate\View\View;

class DataComposer{
    
    public function compose(View $view)
    {

        $tipo_view = "sidebar-collapse";

        $view->with(["view"=>$tipo_view]);
    }
}