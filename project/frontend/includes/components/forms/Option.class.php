<?php

namespace components\forms;

class Option extends \components\Component {
    public \components\Component|string $display;
    public string $value;
    public bool $selected;
    public bool $disabled;

    public function __construct(\components\Component|string $display, string $value, bool $selected = false, bool $disabled = false) {
        parent::__construct();
        $this->display = $display;
        $this->value = $value;
        $this->selected = $selected;
        $this->disabled = $disabled;
    }

    public function display(): void {
        $display = $this->display;
        $value = $this->value;
        $selected = $this->selected;
        $disabled = $this->disabled;
        ?>
            <option value="<?php output($value); ?>" <?php if($selected): ?>selected<?php endif; ?> <?php if($disabled): ?>disabled<?php endif; ?>>
                <?php if($display instanceof \components\Component): ?>
                    <?php $display->display(); ?>
                <?php else: ?>
                    <?php output($display); ?>
                <?php endif; ?>
            </option>
        <?php
    }
}
