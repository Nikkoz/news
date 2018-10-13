<?php

namespace news\dispatchers;


interface EventDispatcher
{
    public function dispatch($event): void;
}