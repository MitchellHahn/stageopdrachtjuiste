<x-mail::message>
    Geachte {{ $contact }},
    Hierbij dien ik een factuur voor de maand {{ $maand }}, in.

    Met vriendelijke groet,
    {{ $from }}
{{--    {{ config('app.name') }}--}}
</x-mail::message>
