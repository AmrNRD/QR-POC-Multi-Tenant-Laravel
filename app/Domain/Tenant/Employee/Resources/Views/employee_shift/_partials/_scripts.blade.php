<script>

    var vue = new Vue({
        el: '#kt_page_portlet',
        data: {
            fData: {
                employee_id: '{{ getData($data, 'employee_id') }}',
                shift_id: '{{ getData($data, 'shift_id') }}',
                from: '{{ getData($data, 'from') }}',
                to: '{{ getData($data, 'to') }}',
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
                            title:"Employee shift Saved",
                            subtitle:"Employee shift",
                            body:"Employee shift has been inserted successfully in the system"
                        },
                        fail:{
                            title:"Failed",
                            subtitle:"Fail",
                            body:"Employee shift has not been inserted successfully in the system"
                        }
                    }
                }
                if(option == 'continue'){
                    request.redirect = '{{ route("employee_shifts.create") }}'
                }else{
                    request.redirect = '{{ route("employee_shifts.index") }}'
                }

                this.isLoading = true

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
