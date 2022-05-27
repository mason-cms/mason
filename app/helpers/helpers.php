<?php

function site()
{
    return new \App\Models\Site;
}

function theme($name = null)
{
    return new \App\Models\Theme($name);
}
