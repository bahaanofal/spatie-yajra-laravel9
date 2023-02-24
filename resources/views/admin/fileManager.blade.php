<x-admin-layout title="{{ __('File Manager') }}">

    
    @push('fileManager')
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <link href="{{ asset('vendor/file-manager/css/file-manager.css') }}" rel="stylesheet">
    @endpush

    <div class="container">
        <div class="row">
            <div class="col-md-12" id="fm-main-block">
                <div id="fm" style="height: 600px;"></div>
            </div>
        </div>
    </div>

    @push('fileManagerScripts')
        <!-- File manager -->
        <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('fm-main-block').setAttribute('style', 'height:' + window.innerHeight + 'px');

                fm.$store.commit('fm/setFileCallBack', function(fileUrl) {
                    window.opener.fmSetLink(fileUrl);
                    window.close();
                });
            });
        </script>
    @endpush

</x-admin-layout>