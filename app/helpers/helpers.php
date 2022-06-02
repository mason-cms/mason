<?php

function site()
{
    return \App\Models\Site::getInstance();
}

function theme($name = null)
{
    return \App\Models\Theme::getInstance($name);
}
