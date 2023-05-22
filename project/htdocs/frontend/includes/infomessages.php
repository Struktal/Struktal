<div class="infomessages-list">
    <?php foreach (InfoMessage::getMessages() as $infoMessage): ?>
        <div class="infomessage" message-type="<?php output($infoMessage->getTypeFormatted()); ?>">
            <?php output($infoMessage->getMessage()); ?>
        </div>
    <?php endforeach; ?>
</div>