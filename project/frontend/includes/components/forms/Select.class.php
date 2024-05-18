<?php

namespace components\forms;

class Select extends \components\Component {
    public array $attributes;
    public array $options;
    public string $class;

    public function __construct(array $attributes, array $options, string $class = "") {
        parent::__construct();
        $this->attributes = $attributes;
        $this->options = $options;
        $this->class = $class;
    }

    public function display(): void {
        $attributes = $this->attributes;
        $options = $this->options;
        $class = $this->class;
        $labelBeforeInput = $this->labelBeforeInput();
        ?>
            <select class="<?php if($labelBeforeInput): ?>w-full<?php endif; ?> outline-primary p-2 border border-gray rounded placeholder:text-font-light <?php output($class); ?>"
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
                <?php foreach($options as $option): ?>
                    <?php $option->display(); ?>
                <?php endforeach; ?>
            </select>
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
