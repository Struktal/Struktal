<div class="infomessages-list">
    <?php foreach (InfoMessage::getMessages() as $infoMessage): ?>
        <div class="infomessage" message-type="<?php echo $infoMessage->getTypeFormatted(); ?>">
            <p>
                <?php echo $infoMessage->getMessage(); ?>
            </p>
        </div>
    <?php endforeach; ?>
</div>