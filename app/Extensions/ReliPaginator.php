<?php 

namespace App\Extensions;

use Illuminate\Pagination\LengthAwarePaginator;

class ReliPaginator extends LengthAwarePaginator
{
	public function __construct($items, $total, $perPage, $currentPage = null, array $options = [])
    {
    	$currentPage = max( $currentPage , 1 ) ; 
    	$perPage = $perPage < 0 ? $total : $perPage;
    	$offset = max( $perPage * ($currentPage - 1), 0 ) ;
    	$items = $items->slice($offset, $perPage);
        parent::__construct($items, $total, $perPage, $currentPage, $options);
    }

    public function toPagingArray()
    {
        return [
            'total' => $this->total(),
            'per_page' => (int) $this->perPage(),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
            'from' => $this->firstItem(),
            'to' => $this->lastItem(),
        ];
    }

    public function getData()
    {
    	return $this->items->values()->toArray();
    }
}