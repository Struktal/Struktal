<?php

/**
 * @var string $label
 * @var string $class
 * @var array $attributes
 */

$labelAfterInput = isset($attributes["type"]) && in_array($attributes["type"], ["checkbox", "radio"]);

?>

<div class="w-full <?php if($labelAfterInput): ?>flex items-center gap-1<?php endif; ?> <?php output($class); ?>">
    <?php if(!empty($label) && !$labelAfterInput): ?>
        <label class="text-sm font-bold"
            <?php if(isset($attributes["name"])): ?> for="<?php output($attributes["name"]); ?>" <?php endif; ?>
        >
            <?php output($label); ?>
            <?php if(isset($attributes["required"]) && $attributes["required"]): ?>
                <span class="text-primary">
                    *
                </span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <input class="<?php if(!$labelAfterInput): ?>w-full<?php endif; ?> outline-primary p-2 border border-gray rounded placeholder:text-font-light"
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

    <?php if(!empty($label) && $labelAfterInput): ?>
        <label class="text-sm font-bold"
               <?php if(isset($attributes["name"])): ?> for="<?php output($attributes["name"]); ?>" <?php endif; ?>
        >
            <?php output($label); ?>
            <?php if(isset($attributes["required"]) && $attributes["required"]): ?>
                <span class="text-primary">
                    *
                </span>
            <?php endif; ?>
        </label>
    <?php endif; ?>
</div>
