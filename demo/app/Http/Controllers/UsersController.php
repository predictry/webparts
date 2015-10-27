<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller,
    App\Visitor,
    Everyman\Neo4j\Cypher\Query;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $user_model = new Visitor();
        $tenant     = 'bukalapak';

        $client      = \DB::connection('neo4j')->getClient();
        $currentPage = \Input::get("page", 1);
        $emails      = [];

        $perPage = 10000;

        $skip     = ($currentPage == 1) ? 0 : ($currentPage * $perPage) - $perPage;
        $strQuery = 'MATCH (n:`User`:`' . $tenant . '`) return n SKIP ' . '{skip}' . ' LIMIT {limit}';
        $query    = new Query($client, $strQuery, ['skip' => $skip, 'limit' => $perPage]);
        $results  = $query->getResultSet();

        foreach ($results as $row) {
            $attributes = $row['t']->getProperties();
            $user       = $user_model->newFromBuilder($attributes);
            if (isset($user->email)) {
                array_push($emails, $user->email);
            }
        }

    }

}
