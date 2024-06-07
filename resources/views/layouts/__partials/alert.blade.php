@if ($message = Session::get('success'))
    <script>
        Toastify({
            text: "{{ $message }}",
            close: true,
            backgroundColor: "#16a34a",
            newWindow: true,
            stopOnFocus: true,
            className: "toast successToast",
            duration: 4000,
        }).showToast();
    </script>
@elseif ($message = Session::get('error'))
    <script>
        Toastify({
            text: "{{ $message }}",
            close: true,
            backgroundColor: "#dc2626",
            newWindow: true,
            stopOnFocus: true,
            className: "toast errorToast",
            duration: 4000,
        }).showToast();
    </script>
@endif
