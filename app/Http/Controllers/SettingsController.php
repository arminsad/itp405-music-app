<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;

class SettingsController extends Controller
{
   
    public function index()
    {
        $configs = Configuration::where('name', '=', 'maintenance-mode');
        return view('admin', [
            'configs' => $configs,
        ]);
    }
    public function toggle (Request $request)
    {
        $config = Configuration::where('name', '=', 'maintenance-mode')->first();
        if (isset($_POST['maintenance-mode']))
        {
            $config->value = TRUE;
        }
        else
        {
            $config->value = FALSE;
        }
        $config->save();

        return redirect()->route('admin');

    }
}