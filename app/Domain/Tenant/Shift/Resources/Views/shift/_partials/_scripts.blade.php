<script>

    var vue = new Vue({
        el: '#kt_page_portlet',
        data: {
            fData: {
                name: '{{ getData($data, 'name') }}',
                name: '{{ getData($data, 'threshold') }}',
                name: '{{ getData($data, 'start_at') }}',
                name: '{{ getData($data, 'end_at') }}',
                name: '{{ getData($data, 'start_date') }}',
                name: '{{ getData($data, 'end_date') }}',
                name: '{{ getData($data, 'type') }}',
                /**/
                @if ($action == 'edit')
                    _method: 'PATCH',
                @endif
            },
            isLoading: false,
            validation_errors: [],
        },
        mounted () {

        },
        methods: {
            submit (option = 'create') {

                let request = {

                    method: "post",

                    url:'{{ $submitUrl }}',

                    data:this.fData,

                    toaster:{
                        success:{
                            title:"Shift Saved",
                            subtitle:"Shift",
                            body:"Shift has been inserted successfully in the system"
                        },
                        fail:{
                            title:"Failed",
                            subtitle:"Fail",
                            body:"Shift has not been inserted successfully in the system"
                        }
                    }
                }

                this.isLoading = true;

                this.submitForm(
                    request,
                    (res)=>{
                        this.isLoading = false
                    },(err)=>{
                        this.isLoading = false
                    });

            },
        },
    });
</script>
