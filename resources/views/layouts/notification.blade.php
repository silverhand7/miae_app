
    @if (Session::get('success'))
        <script type="text/javascript">
            $(document).ready(function(){
                $.notify({
                    icon: 'ti-check-box',
                    message: "<b>Congratulations</b>! <br> <?= Session::get('success') ?>"

                },{
                    type: 'success',
                    timer: 4000
                });

            });
        </script>
    @endif

    @if (Session::get('danger'))
        <script type="text/javascript">
            $(document).ready(function(){
                $.notify({
                    icon: 'ti-close',
                    message: "<b>Ooops!</b>! <br> <?= Session::get('danger') ?>"

                },{
                    type: 'danger',
                    timer: 4000
                });

            });
        </script>
    @endif

    @if (Session::get('warning'))
        <script type="text/javascript">
            $(document).ready(function(){
                $.notify({
                    icon: 'ti-info-alt',
                    message: "<b>Ooops!</b>! <br> <?= Session::get('warning') ?>"

                },{
                    type: 'warning',
                    timer: 4000
                });

            });
        </script>
    @endif