<x-mail::message>
# Task Reminder

You have a task that is due soon:

Task Name: {{ $name }} <br>
From: My Day <br>
Due Date: {{ \Carbon\Carbon::parse($due_date)->format('d M Y')}} 
    
{{-- <x-mail::button :url="''">
Button Text
</x-mail::button> --}}

Thank you for using Doodies.<br>
Doodies Team.
</x-mail::message>
