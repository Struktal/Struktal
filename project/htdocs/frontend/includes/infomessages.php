<?php if (InfoMessage::hasMessages()): ?>
    <div class="infomessages-list">
        <?php foreach (InfoMessage::getMessages() as $infoMessage): ?>
            <div class="infomessage" message-type="<?php echo $infoMessage->getTypeFormatted(); ?>">
                <?php echo $infoMessage->getMessage(); ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>