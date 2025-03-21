<?php

namespace App\Controllers;

use App\Controllers\Controller;

class PreferencesController extends Controller {
    /**
     * Constructor class
     */
    public function __construct() {
        $this->loadView('PreferencesView');
    }

    /**
     * Undocumented function
     *
     * @param int $key_user The user's primary key
     * @return void
     */
    public function display(): void {
        $this->View->display();
    }
}