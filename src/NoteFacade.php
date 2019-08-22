<?php


namespace Note;


use Illuminate\Support\Facades\Facade;

class NoteFacade extends Facade {
    /**
     * ------------------------------------------
     * Get the registered name of the component.
     * ------------------------------------------
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'Note';
    }
}
