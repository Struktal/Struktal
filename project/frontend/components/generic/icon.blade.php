@if(!empty($icon) && file_exists(__APP_DIR__ . "/htdocs/static/img/icons/" . $icon))
    {!! file_get_contents(__APP_DIR__ . "/htdocs/static/img/icons/" . $icon) !!}
@else
    !!! Icon not found: {{ $icon }} !!!
@endif
