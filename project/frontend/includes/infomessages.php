<div class="flex flex-col">
    <?php foreach (InfoMessage::getMessages() as $infoMessage): ?>
        <div class="inline-block w-full p-4 mb-4 border rounded
            border-infomessage-<?php output($infoMessage->getType()->getFormatted()); ?>-border
            bg-infomessage-<?php output($infoMessage->getType()->getFormatted() ?? "none"); ?>-background"
        >
            <?php output($infoMessage->getMessage()); ?>
        </div>
    <?php endforeach; ?>
</div>
