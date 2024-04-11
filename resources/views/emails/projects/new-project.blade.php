<x-mail::message>
# Benvenuto {{ $user }}

Il tuo progetto "{{ $nome_project }}" è stato creato correttamente

<x-mail::button :url="$url_project">
View Project
</x-mail::button>

Grazie,<br>
{{ config('app.name') }}
</x-mail::message>
