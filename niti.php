<?php

class Niti
{
    public function __construct( $items, $properties, $count_of_threads = 20, $fun )
    {
        $pool = new NitiPool( $count_of_threads, 'NitiWebWorker', [ $properties ] );
        foreach( $items as $item )
        {
            $ww = new NitiWebWork( $item, $fun );
            $pool->submit( $ww );
        }

        $pool->collect(function($work)
        {
            return $work->isComplete();
        });
        $pool->shutdown();
        unset( $pool );
    }
}

class NitiWebWorker extends Worker
{
    public $data;

    public function __construct( $data )
    {
        $this->data = $data;
    }

    public function run()
    {
    }
}

class NitiWebWork extends Threaded
{
    protected $is_complete;
    protected $item;
    protected $fun;

    public function __construct( $item, $fun )
    {
        $this->item = $item;
        $this->fun = $fun;
        $this->is_complete = false;
    }

    public function run()
    {
        call_user_func( $this->fun, $this->item, $this->worker->data, $this );
        $this->is_complete = true;
    }

    public function isComplete()
    {
        return $this->is_complete;
    }
}

class NitiPool extends Pool
{
}


