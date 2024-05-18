<?php

namespace components\forms;

class InputGroup extends \components\Component {
    public \components\Component $inputComponent;
    public ?string $label;
    public string $class;

    public function __construct(\components\Component $inputComponent, ?string $label = null, string $class = "") {
        parent::__construct();
        $this->inputComponent = $inputComponent;
        $this->label = $label;
        $this->class = $class;
    }

    public function display(): void {
        $inputComponent = $this->inputComponent;
        $label = $this->label;
        $class = $this->class;

        $inputName = null;
        if(method_exists($inputComponent, "getInputName")) {
            $inputName = $inputComponent->getInputName();
        }

        $required = false;
        if(method_exists($inputComponent, "isRequired")) {
            $required = $inputComponent->isRequired();
        }

        $labelBeforeInput = true;
        if(method_exists($inputComponent, "labelBeforeInput")) {
            $labelBeforeInput = $inputComponent->labelBeforeInput();
        }
        ?>
            <div class="w-full <?php if(!$labelBeforeInput): ?>flex items-center gap-1<?php endif; ?> <?php output($class); ?>">
                <?php if(!$labelBeforeInput): ?>
                    <?php $inputComponent->display(); ?>
                <?php endif; ?>

                <?php if(!empty($label)): ?>
                    <label class="text-sm font-bold"
                        <?php if(!empty($inputName)): ?> for="<?php output($inputName); ?>" <?php endif; ?>
                    >
                        <?php output($label); ?>
                        <?php if($required): ?>
                            <span class="text-primary">
                                *
                            </span>
                        <?php endif; ?>
                    </label>
                <?php endif; ?>

                <?php if($labelBeforeInput): ?>
                    <?php $inputComponent->display(); ?>
                <?php endif; ?>
            </div>
        <?php
    }
}
