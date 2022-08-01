<?php

return function ($container){
    $container["GuestEntryController"]=function ()
    {
        return new \App\Controllers\GuestEntryController;
    };
};