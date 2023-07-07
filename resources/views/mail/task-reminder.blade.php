<x-mail::message>
# Task Reminder

Dear {{ $user }},
    
You have a task that is due soon:

Task Name: {{ $name }} <br>
Due Date: {{ \Carbon\Carbon::parse($due_date)->format('d M Y H:i')}} 

{{-- <x-mail::button :url="''">
Button Text
</x-mail::button> --}}

Thank you for using Doodies.<br>
Doodies Team.
{{-- {{ config('app.name') }} --}}
</x-mail::message>
