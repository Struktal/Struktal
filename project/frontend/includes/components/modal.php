<?php
use jensostertag\Templify\Templify;
?>

<dialog id="modal">
    <div class="modal-header">
        <h2 class="nomargin">
            <span id="modal-content-title"></span>
        </h2>
        <div class="input-group nomargin">
            <button class="button icon-button primary-button modal-abort-button">
                <?php Templify::include("components/icon.php", ["icon" => "close.svg"]); ?>
                <span class="modal-content-abort">Cancel</span>
            </button>
        </div>
    </div>
    <div class="modal-body" id="modal-content-body">
    </div>
    <div class="modal-footer">
        <div class="input-group nomargin">
            <button class="button icon-button secondary-button modal-confirm-button">
                <?php Templify::include("components/icon.php", ["icon" => "check.svg"]); ?>
                <span class="modal-content-confirm">Confirm</span>
            </button>
        </div>
        <div class="input-group nomargin">
            <button class="button icon-button primary-button modal-abort-button">
                <?php Templify::include("components/icon.php", ["icon" => "close.svg"]); ?>
                <span class="modal-content-abort">Cancel</span>
            </button>
        </div>
    </div>
</dialog>
