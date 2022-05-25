<?php

interface EntryCRUDInterface
{
    public function add();
    public function edit($name, $color);
    public function delete();
}