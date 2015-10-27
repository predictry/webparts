<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller,
    Everyman\Neo4j\Cypher\Query;

class TenantsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $tenants = [
            [
                'name' => 'Family Nara',
                'id'   => 'FAMILYNARA2014'
            ],
            [
                'name' => 'SOUKAI',
                'id' => 'SOUKAIMY'
            ],
            [
                'name' => 'Bukalapak',
                'id'   => 'bukalapak'
            ],
            [
                'name' => 'Pricearea',
                'id'   => 'pricearea2'
            ],
            [
                'name' => 'Groupon Indonesia',
                'id'   => 'grouponid'
            ],
            [
                'name' => 'Redmart',
                'id'   => 'redmart'
            ]
        ];

        return \View::make('tenants.list', ['tenants' => $tenants, 'tenant' => '']);
    }

}
