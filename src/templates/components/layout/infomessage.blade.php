<div class="inline-block w-full p-4 mb-4 bg-opacity-40 border rounded
    @if($type === InfoMessageType::SUCCESS) bg-safe-background border-safe
    @elseif($type === InfoMessageType::ERROR) bg-danger-background border-error
    @elseif($type === InfoMessageType::WARNING) bg-warning-background border-warning
    @elseif($type === InfoMessageType::INFO) bg-info-background border-info
    @else bg-gray border-gray
    @endif"
     data-message-type="{{ $type->getFormatted() }}"
>
    {{ $slot }}
</div>
