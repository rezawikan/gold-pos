<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('refresh-gold-stock', function () {
    return Auth::check();
});
