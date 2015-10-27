<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller,
    App\Item,
    Everyman\Neo4j\Cypher\Query,
    Symfony\Component\HttpFoundation\Response;

class ItemsController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $item_id
     * @return Response
     */
    public function show($tenant, $item_id)
    {
        $item       = false;
        $item_model = new Item();
        $client     = \DB::connection('neo4j')->getClient();
        $strQuery   = 'MATCH (n:`Item`:`' . $tenant . '` {id:"' . $item_id . '"}) return n';
        $query      = new Query($client, $strQuery);
        $result     = $query->getResultSet();

        foreach ($result as $row) {
            $attributes = $row['t']->getProperties();
            $item       = $item_model->newFromBuilder($attributes);
        }

        if ($item) {
            return \Response::json(['error' => false, 'data' => ['item' => $item], 'message' => '', 'status' => 200], 200);
        }
        else
            return \Response::json(['error' => false, 'message' => 'Item not found', 'status' => 404], 404);
    }

}
