<?php

class HelpTopicTable extends Doctrine_Table
{
  public function getAnswers($category_id){
       $q = Doctrine_Query::create()
            ->select('ht.*')
            ->from('HelpTopic ht')
            ->where('ht.help_category_id=?',$category_id);
    return $q->execute();
  }
  public function relatedHelp($category_id,$help_id){
         $q = Doctrine_Query::create()
            ->select('t.*')
            ->from('HelpTopic t')
            ->where('t.help_category_id=?',$category_id)
            ->andwhere('t.id <>?',$help_id)
            ->OrderBy('t.Read_count DESC')
            ->limit(5);
    return $q->execute();
  }
  public function helpClick(){
        echo "dddd";die;
  }
}