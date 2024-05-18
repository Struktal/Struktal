<?php

/**
 * @var string $label
 * @var string $class
 * @var array $attributes
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

    <textarea class="w-full outline-primary p-2 border border-gray rounded placeholder:text-font-light resize-y"
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
</div>
