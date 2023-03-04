{{--dit is de e-mail dat wordt verzonden wanneer er een factuur wordt verzonden naar een klant--}}

<x-mail::message>
    {{--  obeject voor naam van de contactpersoon van de klant, tonen  --}}
    Geachte {{ $contact }},
    {{--  Object voor de gekozen periode van waar factuur wordt aangemaakt, tonen  --}}
    Hierbij dien ik een factuur voor de maand {{ $maand }}, in.

    Met vriendelijke groet,
    {{--  object voor naam van de verzonder (zpper), tonen  --}}
    {{ $from }}
</x-mail::message>
