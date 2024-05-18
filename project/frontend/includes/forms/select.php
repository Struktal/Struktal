<?php

/**
 * @var string $label
 * @var string $class
 * @var array $attributes
 * @var array $options
 */

?>

<div class="w-full <?php output($class); ?>">
    <?php if(!empty($label)): ?>
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

    <select class="w-full outline-primary p-2 border border-gray rounded placeholder:text-font-light"
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
            <option value="<?php output($option["value"]); ?>"
                <?php if(isset($option["selected"]) && $option["selected"]): ?>
                    selected
                <?php endif; ?>
                <?php if(isset($option["disabled"]) && $option["disabled"]): ?>
                    disabled
                <?php endif; ?>
            >
                <?php output($option["text"]); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
