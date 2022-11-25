<?php

namespace App\Http\Controllers;

// require_once __DIR__.'/../vendor/autoload.php';

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class firebaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
        // $serviceaccount = ServiceAccount::fromJsonFile(__DIR__.'/firebase_key.json');
        $firebase = (new Factory)
            ->withDatabaseUri('https://tugas-akhir-pemin-default-rtdb.asia-southeast1.firebasedatabase.app/');
            // ->withServiceAccount(__DIR__.'/firebase_key.json');
        $database = $firebase->createDatabase();
        $ref = $database->getReference('Subjects');
        $ref->getChild($key)->set([
            'SubjectName' => 'Laravel'
        ]);
        $key = $ref->push()->getKey();
        return $key;
    }
}
