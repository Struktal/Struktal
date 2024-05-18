<?php

namespace components\forms;

class Button extends \components\Component {
    public \components\Component|string $display;
    public string $theme;
    public array $attributes;
    public string $class;

    public function __construct(\components\Component|string $display, string $theme = "primary", array $attributes = [], string $class = "") {
        parent::__construct();
        $this->display = $display;
        $this->theme = $theme;
        $this->attributes = $attributes;
        $this->class = $class;
    }

    public function display(): void {
        $display = $this->display;
        $theme = $this->theme;
        $attributes = $this->attributes;
        $class = $this->class;
        ?>
        <button class="px-6 py-2 border rounded transition-all <?php if($theme === "primary"):
            ?>text-primary-font bg-primary border-primary outline-primary hover:bg-primary-effect hover:border-primary-effect<?php elseif($theme === "secondary"): ?>
            text-secondary-font bg-secondary border-secondary outline-secondary hover:bg-secondary-effect hover:border-secondary-effect<?php elseif($theme === "gray"): ?>
            text-gray-font bg-gray border-gray outline-gray hover:bg-gray-effect hover:border-gray-effect<?php endif;
            ?> <?php output($class); ?>"
            <?php
            foreach($attributes as $key => $value):
                ?> <?php
                if(is_bool($value) && $value):
                    ?> <?php
                    output($key);
                    ?> <?php
                elseif(!empty($value)):
                    ?> <?php
                    output($key); ?>="<?php output($value); ?>" <?php
                    ?> <?php
                endif;
                ?> <?php
            endforeach;
            ?>>
                <?php if($display instanceof \components\Component): ?>
                    <?php $display->display(); ?>
                <?php else: ?>
                    <?php output($display); ?>
                <?php endif; ?>
            </button>
        <?php
    }

    public function getInputName(): ?string {
        return $this->attributes["name"];
    }

    public function isRequired(): bool {
        return isset($this->attributes["required"]) && $this->attributes["required"];
    }

    public function labelBeforeInput(): bool {
        return true;
    }
}
