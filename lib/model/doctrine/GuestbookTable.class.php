<?php

class GuestbookTable extends Doctrine_Table
{
	public function getSearchQuery(){
		 $q = Doctrine_Query::create()
		            ->select('g.*')
		            ->where('g.confirmed',1)
		            ->orderBy('g.created_at DESC')
		            ->from('Guestbook g');
		
		 return $q;
	}
	
	public function getLastEntry() {
 		$r = Doctrine_Query::create()
		            ->select('g.*')
		            ->where('g.confirmed = 1')
		            ->orderBy('g.created_at DESC')
		            ->from('Guestbook g')
		            ->fetchOne();		
		return $r;
	}
	
    
}