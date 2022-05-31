<?php

function site()
{
    return \App\Models\Site::getInstance();
}

function theme()
{
    return \App\Models\Theme::getInstance();
}
