@if(session('success'))
    <script>
        window.sessionSuccess = '{{ session('success') }}';
        window.redirectUrl = "{{ session('redirect') }}";
        window.sweetAlertTitle = 'Success!';
    </script>
@endif

@if($errors->any())
    <script>
        window.errorMessages = `{!! implode('<br>', $errors->all()) !!}`;
        window.sweetAlertTitle = 'Errors!';
    </script>
@endif
