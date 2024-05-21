<div class="flex flex-col">
    @foreach(InfoMessage::getMessages() as $message)
        @component("components.common.infomessage", [
            "type" => $message->getType()
        ])
            {{ $message->getMessage() }}
        @endcomponent
    @endforeach
</div>