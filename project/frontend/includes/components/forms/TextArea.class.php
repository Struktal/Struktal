<?php

namespace components\forms;

class TextArea extends \components\Component {
    public array $attributes;
    public string $class;

    public function __construct(array $attributes, string $class = "") {
        parent::__construct();
        $this->attributes = $attributes;
        $this->class = $class;
    }

    public function display(): void {
        $attributes = $this->attributes;
        $class = $this->class;
        ?>
        <textarea class="w-full outline-primary p-2 border border-gray rounded placeholder:text-font-light resize-y <?php output($class); ?>"
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
            ?>><?php if(isset($attributes["value"])): ?><?php output($attributes["value"]); ?><?php endif; ?></textarea>
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
