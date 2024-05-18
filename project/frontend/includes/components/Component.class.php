<?php

namespace components;

class Component {
    public function __construct() {
        // Implemented in child classes
    }

    public function fetch(): string {
        ob_start();
        $this->display();
        return ob_get_clean();
    }

    public function display(): void {
        // Implemented in child classes
    }
}
