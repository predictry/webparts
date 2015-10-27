<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller,
    App\Item,
    Carbon\Carbon,
    Everyman\Neo4j\Cypher\Query,
    Illuminate\Pagination\LengthAwarePaginator,
    Symfony\Component\HttpFoundation\Response;

class TenantsItemsController extends Controller
{

    private $item_model = null;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct()
    {
        $this->item_model = new Item();
        \View::share(['pageTitle' => 'Recommendation Demo']);
    }

    public function index($tenant)
    {
        $client      = \DB::connection('neo4j')->getClient();
        $currentPage = \Input::get("page", 1);
        $items       = [];
        $perPage     = 12;

        if (!\Cache::has("{$tenant}_total_items")) {
            $strQuery = 'MATCH (n:`Item`:`' . $tenant . '`) return count(n)';
            $query    = new Query($client, $strQuery);
            $results  = $query->getResultSet();
            $total    = $results->current()['t'];

            //CACHE the $total
            $expiresAt = Carbon::now()->addMinutes(1440); //1 day cache
            \Cache::put("{$tenant}_total_items", $total, $expiresAt);
        }
        else
            $total = \Cache::get("{$tenant}_total_items");

        $skip     = ($currentPage == 1) ? 0 : ($currentPage * $perPage) - $perPage;
        $strQuery = 'MATCH (n:`Item`:`' . $tenant . '`) return n SKIP ' . '{skip}' . ' LIMIT {limit}';
        $query2   = new Query($client, $strQuery, ['skip' => $skip, 'limit' => $perPage]);
        $results2 = $query2->getResultSet();

        foreach ($results2 as $row) {
            $attributes = $row['t']->getProperties();
            $item       = $this->item_model->newFromBuilder($attributes);
            array_push($items, $item);
        }

        $paginator = new LengthAwarePaginator($items, $total, $perPage, $currentPage, ['path' => "/tenant/{$tenant}/items"]);
        return \View::make('items.catalog', ['items' => $paginator, 'tenant' => $tenant, 'pageTitle' => ucwords("Items catalog of {$tenant}")]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($tenant, $item_id)
    {
        $item     = false;
        $client   = \DB::connection('neo4j')->getClient();
        if (( $tenant == "SOUKAIMY") && ($item_id[0] == "S")) {
          $itemarray = str_split($item_id);
          $first = "";
        
          for ($i= 0; $i < 4 ; $i++) { 
            $first = $first. $itemarray[$i];
            unset($itemarray[$i]);
          };

          $second= "";
          for ($i= 4; $i < 9; $i++) { 
            $second = $second. $itemarray[$i];
            unset($itemarray[$i]);
          };
          
          $third= "";
          for ($i= 9; $i < 14; $i++) { 
            $third = $third. $itemarray[$i];
            unset($itemarray[$i]);
          };

          $sid = $first."-".$second."_".$third;
          
          $strQuery = 'MATCH (n:`Item`:`' . $tenant . '` {id:"' . $sid . '"}) return n';

          $query    = new Query($client, $strQuery);
          $result   = $query->getResultSet();

          foreach ($result as $row) {
              $attributes = $row['t']->getProperties();
              $item       = $this->item_model->newFromBuilder($attributes);
          }

          return ($item) ? \View::make('items.detail', ['item' => $item, 'tenant' => $tenant, 'pageTitle' => $item->name]) : "Item not found"; 
        }
        else {
          $strQuery = 'MATCH (n:`Item`:`' . $tenant . '` {id:"' . $item_id . '"}) return n';
          $query    = new Query($client, $strQuery);
          $result   = $query->getResultSet();
    
          
          foreach ($result as $row) {
              $attributes = $row['t']->getProperties();
              $item       = $this->item_model->newFromBuilder($attributes);
          }

          return ($item) ? \View::make('items.detail', ['item' => $item, 'tenant' => $tenant, 'pageTitle' => $item->name]) : "Item not found";
        }
    }

}
