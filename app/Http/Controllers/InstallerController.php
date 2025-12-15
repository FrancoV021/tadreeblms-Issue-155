<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstallerController extends Controller
{
    public function index()
    {
        return view('installer.index');
    }

    public function run()
    {
        $output = [];
        exec('bash install.sh 2>&1', $output);

        return response()->json([
            'success' => true,
            'logs' => implode("\n", $output)
        ]);
    }
}

