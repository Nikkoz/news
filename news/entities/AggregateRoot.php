<?php

namespace news\entities;


interface AggregateRoot
{
    public function releaseEvents(): array;
}